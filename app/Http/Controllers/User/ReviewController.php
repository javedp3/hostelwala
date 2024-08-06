<?php

namespace App\Http\Controllers\User;

use App\Models\Hostel;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function reviewStore(Request $request)
    {
        $hostel_id = $request->hostel_id;
        $hostel = Hostel::findOrFail($hostel_id);
        // Check if the user has already submitted a review for this product
        $existingReview = Review::with('user')->where('user_id',auth()->id())
        ->where('hostel_id', $hostel_id)
        ->first();
        if ($existingReview) {
        $notify[] = ['error', 'You have already submitted a review for this hostel'];
        return back()->withNotify($notify);
        }
        $isBooking = Booking::where('tenant_id',auth()->id())
            ->where('hostel_id', $hostel->id)
            ->where('status', 1)
            ->get();
        if ($isBooking->isEmpty()) {
            $notify[]= ['error', 'Please booking this hostel first before reviewing it'];
            return back()->withNotify($notify);
        }
        $request->validate([
            'message' => 'required',
        ]);
        $review = new Review();
        $review->hostel_id = $request->hostel_id;
        $review->user_id =  auth()->id();
        $review->message = $request->message;
        $review->rating = $request->rating;
        $review->save();
        $reviews = $hostel->reviews()->get();
        $reviewCount = $reviews->count();
        $totalRating = $reviews->sum('rating');
        $newAverageRating = $totalRating / $reviewCount;
        // Update review_count and avg_count
        $hostel->review_count = $reviewCount;
        $hostel->average_rating = $newAverageRating;
        $hostel->save();
        $notify[] = ['success','Review submitted successfully'];
        return back()->withNotify($notify);
    } 
}
