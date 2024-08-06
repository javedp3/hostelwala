<?php

namespace App\Http\Controllers\User;

use App\Models\Comment;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\CommunityLike;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommunityRequest;
use App\Models\CommentLike;

class CommunityController extends Controller
{
    public function community_list()
    {
        $pageTitle = 'Community';
        return view($this->activeTemplate . 'community.community', compact('pageTitle'));
    }

    public function communityStore(CommunityRequest $request)
    {
        $pageTitle = 'Community Store';
        $purifier = new \HTMLPurifier();
        $community = new Community();
        $community->user_id = auth()->id();
        $community->title = $request->title;
        $community->description = $purifier->purify($request->description);
        if ($request->image && $request->hasFile('image')) {
            $community->image = fileUploader($request->image, getFilePath('community_post'), getFileSize('community_post'));
        }
        $community->save();
        $notify[] = ['success', 'Community Post Create Successfully'];
        return back()->withNotify($notify);
    }

    public function communityEdit($id)
    {
        $pageTitle = 'Community Post Edit';
        $community = Community::where('id', $id)->first();
        return view($this->activeTemplate . 'community.edit-community', compact('pageTitle', 'community'));
    }

    public function communityUpdate(CommunityRequest $request, $id)
    {
        
        $pageTitle = 'Community update';
        $purifier = new \HTMLPurifier();
        $community = Community::where('id', $id)->first();
        $old_image = $community->image;
        $community->user_id = auth()->id();
        $community->title = $request->title;
        $community->description = $purifier->purify($request->description);
        if ($request->image && $request->hasFile('image')) {
            $community->image = fileUploader($request->image, getFilePath('community_post'), getFileSize('community_post'), $old_image);
        }
        $community->save();
        $notify[] = ['success', 'Community Post update Successfully'];
        return back()->withNotify($notify);
    }

    public function communityDelete($id)
    {
        $pageTitle = 'Community Edit';
        $community = Community::where('id', $id)->first();
        if ($community->image) {
            fileManager()->removeFile(getFilePath('community_post') . '/' . $community->image);
        }
        $community->comments->each->delete();
        $community->delete();
        $notify[] = ['success', 'Community Delete Successfully'];
        return back()->withNotify($notify);
    }


    public function communityLike(Request $request)
    {
        $pageTitle = 'Community Like';
        $community = Community::where('id',$request->community_id)->first();
        $CommunityLike = new CommunityLike();
        $existsCommunityLike = $CommunityLike->where('community_id', $request->community_id)->where('user_id', auth()->id())->first();
        if ($community) {
            if ($existsCommunityLike) {
                $existsCommunityLike->delete();
                $data = $this->total_like_count($CommunityLike,$request,0);
            } else {
                $CommunityLike->community_id = $request->community_id;
                $CommunityLike->user_id = auth()->id();
                $CommunityLike->like = 1;
                $CommunityLike->save();
                $data = $this->total_like_count($CommunityLike,$request,1);
            }
            return response()->json($data);
        }
    }

    public function total_like_count($communityLike,$request,$likeStatus){
        $data = [
            'status' => "success",
            'likeStatus' => $likeStatus,
            'likeCount' => $communityLike->where('community_id', $request->community_id)->count(),
        ];

        return $data;
    }

   
    public function commentLike(Request $request)
    {
        $pageTitle = 'Comment Like';
        $comment = Comment::where('id',$request->comment_id)->first();
        $commentLike = new CommentLike();
        $existsCommentLike = $commentLike->where('comment_id', $request->comment_id)->where('user_id', auth()->id())->first();
        if ($comment) {
            if ($existsCommentLike) {
                $existsCommentLike->delete();
                $data = $this->total_comment_like_count($commentLike,$request,0);
            } else {
                $commentLike->comment_id = $request->comment_id;
                $commentLike->user_id = auth()->id();
                $commentLike->like = 1;
                $commentLike->save();
                $data = $this->total_comment_like_count($commentLike,$request,1);
            }
            return response()->json($data);
        }
    }

    public function total_comment_like_count($commentLike,$request,$likeStatus){
        $data = [
            'status' => "success",
            'likeStatus' => $likeStatus,
            'likeCount' => $commentLike->where('comment_id', $request->comment_id)->count(),
        ];

        return $data;
    }


    public function communityCommentStore(Request $request)
    {
        $request->validate([
            'community_id' => "required|integer",
            'comment' => "required|string"
        ]);
        $pageTitle = 'Community-Comment';
        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->community_id = $request->community_id;
        $comment->comment = $request->comment;
        $comment->save();
        $notify[] = ['success', 'Comment Create Successfully'];
        return back()->withNotify($notify);
    }
}
