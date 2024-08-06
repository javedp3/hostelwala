<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function bookingList(Request $request)
    {
        $pageTitle = 'Booking-List';
        $booking_list = Booking::with('hostel', 'room', 'owner', 'tenant')->where('status', '!=', 0)->orderBy('id', 'desc')->paginate(getPaginate());
        if ($request->search) {
            $booking_list = Booking::with('hostel', 'room', 'owner', 'tenant')
                ->where('status', '!=', 0)
                ->whereHas('owner', function ($q) use ($request) {
                    $q->where('username', 'like', "%$request->search%");
                })
                ->orWhereHas('hostel', function ($q) use ($request) {
                    $q->where('name', 'like', "%$request->search%");
                })
                ->orderBy('id', 'desc')
                ->paginate(getPaginate());
        }
        return view('admin.booking.list', compact('pageTitle', 'booking_list'));
    }
}
