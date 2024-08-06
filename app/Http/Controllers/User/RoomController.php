<?php

namespace App\Http\Controllers\User;

use App\Models\Room;
use App\Models\Image;
use App\Models\Hostel;
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
    public function room_list(Request $request, $hostel_id)
    {
        $pageTitle = 'Room-List';
        $room_lists = Room::with(['hostel'])->where('user_id', auth()->id())
            ->where('hostel_id', $hostel_id)
            ->whereHas('hostel', function ($q) {
                $q->where('user_type', 'user');
            })->orderBy('id', 'desc')
            ->paginate(getPaginate());

        if ($request->search) {
            $room_lists = Room::with(['hostel'])->where('user_id', auth()->id())
                ->where('title', 'like', "%$request->search%")
                ->where('hostel_id', $hostel_id)
                ->whereHas('hostel', function ($q) {
                    $q->where('user_type', 'user');
                })->orderBy('id', 'desc')
                ->paginate(getPaginate());
        }

        return view($this->activeTemplate . 'user.room.list', compact('pageTitle', 'room_lists', 'hostel_id'));
    }

    public function add_room($id)
    {
        $pageTitle = 'Add-Room';
        return view($this->activeTemplate . 'user.room.add', compact('pageTitle', 'id'));
    }

    public function store(RoomRequest $request)
    {
        $hostel = Hostel::where('id', $request->hostel_id)->first();
        if ($hostel && $hostel->user_id == auth()->id() && $hostel->user_type == 'user') {
            $pageTitle = 'Add-Room';
            $room = new Room();
            $room->user_id = auth()->user()->id;
            $room->hostel_id = $hostel->id;
            $room->title = $request->title;
            $room->number = $request->number;
            $room->type = $request->type;
            $room->ac_type = $request->ac_type;
            $room->rooms_or_beds = $request->rooms_or_beds;
            $room->rent_per_day = $request->rent_per_day;
            $room->discount = $request->discount;
            $room->status = 0;
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

    public function edit($hostel_id, Room $room)
    {
        $pageTitle = 'Edit-Room';
        return view($this->activeTemplate . 'user.room.edit', compact('pageTitle', 'room', 'hostel_id'));
    }

    function update(RoomRequest $request, $hostel_id, $room_id)
    {
        $hostel = Hostel::where('id', $hostel_id)->first();
        if ($hostel && $hostel->user_id == auth()->id() && $hostel->user_type == 'user') {
            $pageTitle = 'Update-Room';
            $room = Room::where('id', $room_id)->first();
            $old_image = $room->image;
            $room->user_id = auth()->user()->id;
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
            $notify[] = ['success', 'Room Create successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Your hostel id is not valid'];
            return back()->withNotify($notify);
        }
    }

    function delete($hostel_id, $room_id)
    {
        $pageTitle = 'Delete-Room';
        $hostel = Hostel::where('id', $hostel_id)->first();
        if ($hostel && $hostel->user_id == auth()->id() && $hostel->user_type == 'user') {
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
}
