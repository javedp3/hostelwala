<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Hostel;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Http\Controllers\Controller;

class ManageRoomController extends Controller
{
    public function room_list(Request $request, $hostel_id)
    {
        $pageTitle = 'Room-List';
        $room_list = $this->roomData($hostel_id);
        $pendingRoomCount = $this->pendingRoomCount($hostel_id);
        $hostel = Hostel::findOrFail($hostel_id);
        return view('admin.room.list', compact('pageTitle', 'room_list','hostel','pendingRoomCount'));
        
    }

    public function add_room($hostel_id)
    {
        $pageTitle = 'Add-Room';
        $hostel = Hostel::findOrFail($hostel_id);
        return view('admin.room.add', compact('pageTitle','hostel'));
    }

    public function store(RoomRequest $request,$hostel_id)
    {
        $hostel = Hostel::where('id', $hostel_id)->first();
        if ($hostel && $hostel->user_id == auth('admin')->id() && $hostel->user_type == 'admin') {
            $pageTitle = 'Add-Room';
            $room = new Room();
            $room->user_id = auth('admin')->id();
            $room->hostel_id = $hostel->id;
            $room->title = $request->title;
            $room->number = $request->number;
            $room->type = $request->type;
            $room->ac_type = $request->ac_type;
            $room->rooms_or_beds = $request->rooms_or_beds;
            $room->rent_per_day = $request->rent_per_day;
            $room->discount = $request->discount;
            $room->status = 1;
            if ($request->image && $request->hasFile('image')) {
                $room->image = fileUploader($request->image, getFilePath('room'), getFileSize('room'));
            }
            $room->save();
            $notify[] = ['success', 'Room Create successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Your hostel id is not valid'];
            return back()->withNotify($notify);
        }
    }

    function edit($hostel_id,$room_id)
    {
        $pageTitle = 'Edit-Room';
        $room = Room::with('user', 'hostel')->where('id', $room_id)->first();
        $hostel = Hostel::findOrFail($hostel_id);
        return view('admin.room.edit', compact('pageTitle','hostel','room'));
    }

    function update(RoomRequest $request, $hostel_id, $room_id)
    {
        $hostel = Hostel::where('id', $hostel_id)->first();
        if ($hostel && $hostel->user_id == auth('admin')->id() && $hostel->user_type == 'admin') {
            $pageTitle = 'Update-Room';
            $room = Room::where('id', $room_id)->first();
            $old_image = $room->image;
            $room->user_id = auth('admin')->id();
            $room->hostel_id = $hostel->id;
            $room->title = $request->title;
            $room->number = $request->number;
            $room->type = $request->type;
            $room->ac_type = $request->ac_type;
            $room->rooms_or_beds = $request->rooms_or_beds;
            $room->rent_per_day = $request->rent_per_day;
            $room->discount = $request->discount;
            $room->status = $room->status;
            if ($request->image && $request->hasFile('image')) {
                $room->image = fileUploader($request->image, getFilePath('room'), getFileSize('room'), $old_image);
            }
            $room->save();
            $notify[] = ['success', 'Room Updated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Your hostel id is not valid'];
            return back()->withNotify($notify);
        }
    }

    function delete($hostel_id,$room_id)
    {
        $pageTitle = 'Delete-Room';
        $hostel = Hostel::where('id', $hostel_id)->first();
        if ($hostel && $hostel->user_id == auth('admin')->id() && $hostel->user_type == 'admin') {
            $room = Room::where('id', $room_id)->first();
            if ($room->image) {
                fileManager()->removeFile(getFilePath('room') . '/' . $room->image);
            }
            $room->delete();
            $notify[] = ['success', 'Room Delete successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Your hostel id is not valid'];
            return back()->withNotify($notify);
        }
    }

    public function pending($hostel_id)
    {
        $pageTitle = 'Pending Rooms';
        $room_list = $this->roomData($hostel_id,'pending');
        $pendingRoomCount = $this->pendingRoomCount($hostel_id);
        $hostel = Hostel::findOrFail($hostel_id);
        return view('admin.room.list', compact('pageTitle', 'room_list','hostel','pendingRoomCount'));
    }

    public function active($hostel_id)
    {
        $pageTitle = 'Active Rooms';
        $room_list = $this->roomData($hostel_id,'active');
        $pendingRoomCount = $this->pendingRoomCount($hostel_id);
        $hostel = Hostel::findOrFail($hostel_id);
        return view('admin.room.list', compact('pageTitle', 'room_list','hostel','pendingRoomCount'));
    }

    public function roomStatus(Request $request)
    {
        $hostel = Room::where('id', $request->id)->first();
        if ($hostel->status === 1) {
            $hostel->status = 0;
            $hostel->save();
        } elseif ($hostel->status === 0) {
            $hostel->status = 1;
            $hostel->save();
        }
        return response()->json(
            $hostel = [
                'status' => "success",
                'message' => "Room status updated."
            ],
        );
    }
    protected function roomData($hostel_id, $scope = null)
    {
        if ($scope) {
            $rooms = Room::$scope();
        } else {
            $rooms = Room::query();
        }
        //search

        $request = request();
        if ($request->search) {
            $search = $request->search;
            $rooms  = $rooms->where('title', 'like', "%$request->search%");
        }
        return $rooms->with('user', 'hostel')->where('hostel_id',$hostel_id)->orderBy('id', 'desc')->paginate(getPaginate());
    }


    protected function pendingRoomCount($hostel_id){
        return Room::where('hostel_id',$hostel_id)->where('status',0)->count();
    }
}
