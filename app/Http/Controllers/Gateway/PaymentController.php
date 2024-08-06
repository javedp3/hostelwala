<?php

namespace App\Http\Controllers\Gateway;

use App\Models\Room;
use App\Models\User;
use App\Models\Hostel;
use App\Models\Booking;
use App\Models\Deposit;
use App\Lib\FormProcessor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{

    public function deposit()
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Deposit Methods';
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle'));
    }

    public function depositInsert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_code' => 'required',
            'currency' => 'required',
        ]);


        $user = auth()->user();
        $gate = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->where('method_code', $request->method_code)->where('currency', $request->currency)->first();
        if (!$gate) {
            $notify[] = ['error', 'Invalid gateway'];
            return back()->withNotify($notify);
        }

        if ($gate->min_amount > $request->amount || $gate->max_amount < $request->amount) {
            $notify[] = ['error', 'Please follow payment limit'];
            return back()->withNotify($notify);
        }

        $charge = $gate->fixed_charge + ($request->amount * $gate->percent_charge / 100);
        $payable = $request->amount + $charge;
        $final_amo = $payable * $gate->rate;

        $bookings = Session::get('booking');
        $coupon = Session::get('coupon');
        $bookings = collect($bookings);
        
        $data = new Deposit();
        $data->user_id = auth()->id();
        $data->owner_id = $bookings->first()['owner_id'];
        $data->owner_type = $bookings->first()['owner_type'];
        $data->method_code = $gate->method_code;
        $data->method_currency = strtoupper($gate->currency);
        $data->amount = $request->amount;
        $data->charge = $charge;
        $data->rate = $gate->rate;
        $data->final_amo = $final_amo;
        $data->btc_amo = 0;
        $data->btc_wallet = "";
        $data->trx = getTrx();
        $data->try = 0;
        $data->status = 0;
        $data->save();

        if (!Session::exists('booking')) {
            $notify[] = ['warning', 'Session expired'];
            return back()->withNotify($notify);
        };

        foreach ($bookings as $key => $value) {
            $booking = new Booking();
            $booking->owner_id = $value['owner_id'];
            $booking->tenant_id = auth()->id();
            $booking->deposit_id = $data->id;
            $booking->coupon_id = $coupon->id ?? 0;
            $booking->hostel_id = $value['hostel_id'];
            $booking->room_id = $value['room_id'];
            $booking->owner_type = $value['owner_type'];
            $booking->room_title = $value['title'];
            $booking->rooms_or_beds = $value['roomsOrBeds'];
            $booking->type = $value['type'];
            $booking->check = 2;
            $booking->from_date = $value['checkIn'];
            $booking->to_date = $value['checkOut'];
            $booking->discount = $value['discount'];
            $booking->rent_with_discount = $value['rentWithDiscount'];
            $booking->rent_per_day = $value['rent_per_day'];
            $booking->stay_in_night = $value['daysDiff'];
            $booking->total_amount = $value['rent'];
            $booking->status = 0;
            $booking->save();
        }

        Session::forget("booking");
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }

    public function appDepositConfirm($hash)
    {
        try {
            $id = decrypt($hash);
        } catch (\Exception $ex) {
            return "Sorry, invalid URL.";
        }
        $data = Deposit::where('id', $id)->where('status', 0)->orderBy('id', 'DESC')->firstOrFail();
        $user = User::findOrFail($data->user_id);
        auth()->login($user);
        session()->put('Track', $data->trx);
        return to_route('user.deposit.confirm');
    }


    public function depositConfirm()
    {
        $track = session()->get('Track');
        $deposit = Deposit::where('trx', $track)->where('status', 0)->orderBy('id', 'DESC')->with('gateway')->firstOrFail();

        if ($deposit->method_code >= 1000) {
            return to_route('user.deposit.manual.confirm');
        }


        $dirName = $deposit->gateway->alias;
        $new = __NAMESPACE__ . '\\' . $dirName . '\\ProcessController';

        $data = $new::process($deposit);
        $data = json_decode($data);


        if (isset($data->error)) {
            $notify[] = ['error', $data->message];
            return to_route(gatewayRedirectUrl())->withNotify($notify);
        }
        if (isset($data->redirect)) {
            return redirect($data->redirect_url);
        }

        // for Stripe V3
        if (@$data->session) {
            $deposit->btc_wallet = $data->session->id;
            $deposit->save();
        }

        $pageTitle = 'Payment Confirm';
        return view($this->activeTemplate . $data->view, compact('data', 'pageTitle', 'deposit'));
    }


    public static function userDataUpdate($deposit, $isManual = null)
    {

        if ($deposit->status == 0 || $deposit->status == 2) {
            $deposit->status = 1;
            $deposit->save();

            if ($deposit->owner_type == "user") {
                $user = User::find($deposit->owner_id);
                $user->balance += $deposit->amount;
                $user->save();
            }

            foreach ($deposit->booking as $value) {
                $value->status = 1;
                $value->save();
                $room = Room::with('hostel')->where('id',$value->room_id)->first();
                notify($user, 'BOOKING_COMPLETE', [
                    'method_name' => $deposit->gatewayCurrency()->name,
                    'method_currency' => $deposit->method_currency,
                    'method_amount' => showAmount($deposit->final_amo),
                    'amount' => showAmount($deposit->amount),
                    'charge' => showAmount($deposit->charge),
                    'rate' => showAmount($deposit->rate),
                    'trx' => $deposit->trx,
                    'post_balance' => showAmount($user->balance),
                    'hostel_name' => $room->hostel->name,
                    'room_title' => $room->title,
                    'check_in' => showDateTime($value->from_date,'d M, Y'),
                    'check_out' => showDateTime($value->to_date,'d M, Y'),
                    'stay_in_night' => $value->stay_in_night,
                    'rooms_or_beds' => $value->rooms_or_beds
                ]);
            }

            $transaction = new Transaction();
            $transaction->user_id = $deposit->user_id;
            $transaction->amount = $deposit->amount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = $deposit->charge;
            $transaction->trx_type = '+';
            $transaction->details = 'Payment Via ' . $deposit->gatewayCurrency()->name;
            $transaction->trx = $deposit->trx;
            $transaction->remark = 'Payment';
            $transaction->save();

            if (!$isManual) {
                $adminNotification = new AdminNotification();
                $adminNotification->user_id = $user->id;
                $adminNotification->title = 'Payment successful via ' . $deposit->gatewayCurrency()->name;
                $adminNotification->click_url = urlPath('admin.deposit.successful');
                $adminNotification->save();
            }

            notify($user, $isManual ? 'PAYMENT_APPROVE' : 'PAYMENT_COMPLETE', [
                'method_name' => $deposit->gatewayCurrency()->name,
                'method_currency' => $deposit->method_currency,
                'method_amount' => showAmount($deposit->final_amo),
                'amount' => showAmount($deposit->amount),
                'charge' => showAmount($deposit->charge),
                'rate' => showAmount($deposit->rate),
                'trx' => $deposit->trx,
                'post_balance' => showAmount($user->balance)
            ]);
        }
    }

    public function manualDepositConfirm()
    {
        $track = session()->get('Track');
        $data = Deposit::with('gateway','booking')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }
        if ($data->method_code > 999) {

            $pageTitle = 'Payment Confirm';
            $method = $data->gatewayCurrency();
            $gateway = $method->method;
            return view($this->activeTemplate . 'user.payment.manual', compact('data', 'pageTitle', 'method', 'gateway'));
        }
        abort(404);
    }

    public function manualDepositUpdate(Request $request)
    {

        $track = session()->get('Track');
        $data = Deposit::with('gateway','booking')->where('status', 0)->where('trx', $track)->first();
        if (!$data) {
            return to_route(gatewayRedirectUrl());
        }

        $gatewayCurrency = $data->gatewayCurrency();
        $gateway = $gatewayCurrency->method;
        $formData = $gateway->form->form_data;

        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $data->detail = $userData;
        $data->status = 2; // pending
        $data->save();

        $booking = Booking::where('deposit_id',$data->id)->get();
        foreach ($booking as $value) {
            $value->status = 2; // pending
            $value->save();
        }

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $data->user->id;
        $adminNotification->title = 'Payment request from ' . $data->user->username;
        $adminNotification->click_url = urlPath('admin.deposit.details', $data->id);
        $adminNotification->save();

        notify($data->user, 'PAYMENT_REQUEST', [
            'method_name' => $data->gatewayCurrency()->name,
            'method_currency' => $data->method_currency,
            'method_amount' => showAmount($data->final_amo),
            'amount' => showAmount($data->amount),
            'charge' => showAmount($data->charge),
            'rate' => showAmount($data->rate),
            'trx' => $data->trx
        ]);

        $notify[] = ['success', 'You have payment request has been taken'];
        return to_route('user.deposit.history')->withNotify($notify);
    }
}
