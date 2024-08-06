<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    function coupon_list(){
        $pageTitle = 'Coupon-List';
        $coupon_list = $this->couponData();
        return view('admin.coupons.list', compact('pageTitle', 'coupon_list'));
    }

    public function store(Request $request) {
       
        $request->validate([
            'name' => 'required|string',
            'number' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'percent' => 'required',
            'status' => 'required|in:0,1',
        ]);
     
        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->number = $request->number;
        $coupon->from_date = $request->from_date;
        $coupon->to_date = $request->to_date;
        $coupon->percent = $request->percent;
        $coupon->status = $request->status;
        $coupon->save();

        $notify[] = ['success', 'Coupon create successfully'];
        return back()->withNotify($notify);
    }

    public function couponStatus(Request $request)
    {
        $coupon = Coupon::where('id', $request->id)->first();
        if ($coupon->status === 1) {
            $coupon->status = 0;
            $coupon->save();
        } elseif ($coupon->status === 0) {
            $coupon->status = 1;
            $coupon->save();
        }
        return response()->json(
            $coupon = [
                'status' => "success",
                'message' => "Coupon status updated."
            ],
        );
    }

    protected function couponData($scope = null)
    {
        if ($scope) {
            $coupons = Coupon::$scope();
        } else {
            $coupons = Coupon::query();
        }

        //search
        $request = request();
        if ($request->search) {
            $search = $request->search;
            $coupons  = $coupons->where(function ($hostel) use ($search) {
                $hostel->where('number', 'like', "%$search%");
            });
        }
        return $coupons->orderBy('id', 'desc')->paginate(getPaginate());
    }
}
