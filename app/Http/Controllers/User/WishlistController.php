<?php

namespace App\Http\Controllers\User;

use App\Models\Hostel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function store(Request $request){
        $hostel = Hostel::where('id',$request->hostel_id)->first();
        $exist_wishlist = Wishlist::where('hostel_id',$hostel->id)->where('user_id',auth()->id())->first();
        if($exist_wishlist){
            $exist_wishlist->delete();

            $data = [
                'status' => "success",
                'wishlist' => 0,
                'message' => "Hostel Sub to wishlist",
            ];
            return response()->json($data);
        }else{
            $wishlist = new Wishlist();
            $wishlist->user_id = auth()->id();
            $wishlist->hostel_id = $hostel->id;
            $wishlist->save();

            $data = [
                'status' => "success",
                'wishlist' => 1,
                'message' => "Hostel Add to wishlist",
            ];
            return response()->json($data);
        }
    }

    public function wishlist_list(Request $request){

        $pageTitle = 'Wishlist-List';
        $wishlists = Wishlist::with('hostel','hostel.hostel_images')->where('user_id',auth()->id())->orderBy('id','desc')->paginate(getPaginate());

        if ($request->search) {
            $wishlists = Wishlist::with('hostel','hostel.hostel_images')->where('user_id', auth()->id())
                ->whereHas('hostel',function($q) use ($request){
                    $q->where('name','like',"%$request->search%");
                })
                ->orderBy('id','desc')
                ->paginate(getPaginate());
        }
        return view($this->activeTemplate . 'user.wishlist.list', compact('pageTitle','wishlists'));
    }

    public function delete($id){

        $pageTitle = 'Wishlist-Delete';
        $wishlist = Wishlist::where('id',$id)->first();
        $wishlist->delete();
        $notify[] = ['success', 'Wishlist delete successfully'];
        return back()->withNotify($notify);
    }

}
