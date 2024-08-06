<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Coupon;
use App\Models\Hostel;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function bookingList(Request $request)
    {
        $pageTitle = 'Booking-List';
        $booking_list = Booking::with('coupon')->where('tenant_id', auth()->id())->orderBy('id', 'desc')
            ->paginate(getPaginate());

        if ($request->search) {
            $booking_list = Booking::with('coupon')->where('tenant_id', auth()->id())
                ->where('room_title', 'like', "%$request->search%")
                ->orderBy('id', 'desc')
                ->paginate(getPaginate());
        }
        return view($this->activeTemplate . 'user.booking.list', compact('pageTitle', 'booking_list'));
    }

    public function myBooked(Request $request)
    {
        $pageTitle = 'My-Booked';
        $booking_list = Booking::with('coupon')->where('owner_id', auth()->id())
            ->where('owner_type', 'user')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        if ($request->search) {
            $booking_list = Booking::with('coupon')->where('owner_id', auth()->id())
                ->where('owner_type', 'user')
                ->where('status', 1)
                ->where('room_title', 'like', "%$request->search%")
                ->orderBy('id', 'desc')
                ->paginate(getPaginate());
        }
        return view($this->activeTemplate . 'user.booking.my-booked-list', compact('pageTitle', 'booking_list'));
    }

    public function bookingPreview(Request $request)
    {
        $room = Room::with('hostel')->where('id', $request->roomId)->where('hostel_id', $request->hostelId)->first();
        $checkIn = Carbon::parse($request->checkIn);
        $checkOut = Carbon::parse($request->checkOut);
        $daysDiff = $checkOut->diffInDays($checkIn);

        if ($request->roomType == 'room' && $room->type == $request->roomType) {
            $rent = $room->rent_per_day;
            if ($room->discount) {
                $rent = $room->rent_per_day - (($room->rent_per_day / 100) * $room->discount);
                $rentWithDiscount = $rent;
            }
            $rent = $rent * $daysDiff * $request->roomsOrBeds;
        } elseif ($request->roomType == 'bed' && $room->type == $request->roomType) {
            $rent = $room->rent_per_day;
            if ($room->discount) {
                $rent = $room->rent_per_day - (($room->rent_per_day / 100) * $room->discount);
                $rentWithDiscount = $rent;
            }
            $rent = ($rent * $daysDiff) * $request->roomsOrBeds;
        }
        $bookings = Session::get('booking');
        $bookings = collect($bookings);

        $data = [
            'owner_id' => $room->user_id,
            'owner_type' => $room->hostel->user_type,
            'tenant_id' => auth()->id(),
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'daysDiff' => $daysDiff,
            'hostel_id' => $room->hostel_id,
            'room_id' => $room->id,
            'title' => $room->title,
            'type' => $room->type,
            'rent_per_day' => $room->rent_per_day,
            'rent' => sprintf('%.2f', $rent),
            'discount' => $room->discount,
            'rentWithDiscount' => sprintf('%.2f', $rentWithDiscount),
            'roomsOrBeds' => intval($request->roomsOrBeds),
            'currency' => gs()->cur_sym,
        ];

        if ($bookings->isNotEmpty()) {
            if ($bookings->has($room->id)) {
                $bookings->pull($room->id);
            }

            $bookings->put($room->id, $data);
            Session::put('booking', $bookings);
        } else {
            $newArray[$room->id] = $data;
            Session::put('booking', $newArray);
        }
        $data = [
            'status' => "success",
            'message' => "booking",
            'booking_data' => Session::get('booking'),
        ];
        return response()->json($data);
    }

    public function bookingDelete(Request $request)
    {
        $bookings = Session::get('booking');
        $bookings = collect($bookings);

        if ($bookings->has($request->roomId)) {
            $bookings->pull($request->roomId);
            Session::put('booking', $bookings);
            $data = [
                'status' => "success",
                'message' => "Booking Delete",
                'booking_data' => Session::get('booking'),
            ];
        } else {
            $data = [
                'status' => "error",
                'message' => "booking not found",
                'booking_data' => Session::get('booking'),
            ];
        }

        return response()->json($data);
    }


    public function couponApply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);
        $coupon = Coupon::where('number', $request->coupon_code)->where('status', 1)->first();
        if (!$coupon) {
            $data = [
                'status' => "error",
                'message' => "Invalid Coupon",
            ];
            Session::forget('coupon');
        } elseif ($coupon->from_date > now()) {
            $data = [
                'status' => "error",
                'message' => "Your coupon date not started",
            ];
            Session::forget('coupon');
        } elseif ($coupon->to_date < now()) {

            $data = [
                'status' => "error",
                'message' => "Your coupon date expired",
            ];
            Session::forget('coupon');
        } else {
            $data = [
                'status' => "success",
                'message' => "Your coupon code is valid",
                'data' => $coupon->percent
            ];
            Session::forget('coupon');
            Session::put('coupon', $coupon);
        }
        return response()->json($data);
    }


    public function bookingNow()
    {
        if (!Session::exists('booking')) {
            $notify[] = ['warning', 'Please room select first'];
            return back()->withNotify($notify);
        }
        $pageTitle = 'Payment';
        $bookings = Session::get('booking');

        // Get the values of the 'rent' key
        $rents = collect($bookings)->pluck('rent');
        $totalRents = $rents->sum();

        if (Session::exists('coupon')) {
            $coupon = Session::get('coupon');
            $totalRents = $totalRents - ($totalRents / 100) * $coupon->percent;
        }

        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        return view($this->activeTemplate . 'user.payment.deposit', compact('gatewayCurrency', 'pageTitle', 'gatewayCurrency', 'totalRents'));
    }
}
