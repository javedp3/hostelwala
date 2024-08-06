<?php

namespace App\Http\Controllers\Admin;

use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommunityController extends Controller
{
    public function community_list(){

        $pageTitle = 'Posts';
        $communities = $this->communityData();
        return view('admin.community.list', compact('pageTitle', 'communities'));
    }

    public function communityStatus(Request $request)
    {
        $community = Community::where('id', $request->id)->first();
        if ($community->status === 1) {
            $community->status = 0;
            $community->save();
        } elseif ($community->status === 0) {
            $community->status = 1;
            $community->save();
        }
        return response()->json(
            $community = [
                'status' => "success",
                'message' => "Community status updated."
            ],
        );
    }

    protected function communityData($scope = null)
    {
        if ($scope) {
            $communities = Community::$scope();
        } else {
            $communities = Community::query();
        }

        //search
        $request = request();
        if ($request->search) {
            $search = $request->search;
            $communities  = $communities->with('user')->where(function ($hostel) use ($search) {
                $hostel->where('number', 'like', "%$search%");
            });
        }
        return $communities->orderBy('id', 'desc')->paginate(getPaginate());
    }
   
}
