<?php

namespace App\Http\Controllers\User;

use App\Models\Room;
use App\Models\User;
use App\Models\Hostel;
use App\Models\HostelImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HostelRequest;
use Illuminate\Http\RedirectResponse;

class HostelController extends Controller
{
    public function hostel_list(Request $request)
    {
        $pageTitle = 'Hostel-List';
        $hostel_list = Hostel::where('user_id', auth()->id())
            ->where('user_type', 'user')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        if ($request->search) {
            $hostel_list = Hostel::where('user_id', auth()->id())
                ->where('name', 'like', "%$request->search%")
                ->orderBy('id', 'desc')
                ->paginate(getPaginate());
        }

        return view($this->activeTemplate . 'user.hostel.list', compact('pageTitle', 'hostel_list'));
    }

    public function add_hostel()
    {
        $pageTitle = 'Add-Hostel';
        return view($this->activeTemplate . 'user.hostel.add', compact('pageTitle'));
    }

    public function store(HostelRequest $request): RedirectResponse
    {

        $pageTitle = 'Create-Hostel';
        if (count($request->facilities) != count($request->icons)) {
            $notify[] = ['error', 'Some data are missing'];
            return back()->withNotify($notify);
        }
        $hostel = new Hostel();
        $purifier = new \HTMLPurifier();
        $hostel->user_id = auth()->user()->id;
        $hostel->user_type = "user";
        $hostel->name = $request->name;
        $hostel->hostel_rules = $purifier->purify($request->hostel_rules);
        $hostel->facilities = $request->facilities;
        $hostel->address = $request->location;
        $hostel->city = $request->city_input;
        $hostel->state = $request->state_input;
        $hostel->country = $request->country_input;
        $hostel->latitude = $request->lat_input;
        $hostel->longitude = $request->lon_input;
        $hostel->icons = $request->icons;
        $hostel->description = $purifier->purify($request->description);
        $hostel->status = 0;
        $hostel->save();
        if ($request->hasFile('images')) {
            try {
                foreach ($request->images as $index => $img) {
                    $hostel_image = new HostelImage();
                    $hostel_image->user_id = auth()->id();
                    $hostel_image->hostel_id = $hostel->id;
                    $hostel_image->path = '/' . date("Y") . '/' . date("m") . '/';
                    if ($index === 0) {
                        $hostel_image->image = fileUploader($img, getFilePath('hostel') . $hostel_image->path, getFileSize('hostel'), '', "415x245");
                    } else {
                        $hostel_image->image = fileUploader($img, getFilePath('hostel') . $hostel_image->path, getFileSize('hostel'));
                    }
                    $hostel_image->save();
                }
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'Hostel Create successfully'];
        return back()->withNotify($notify);
    }

    function edit($id)
    {
        $pageTitle = 'Edit-Hostel';
        $hostel = Hostel::with('hostel_images')->where('id', $id)->first();
        return view($this->activeTemplate . 'user.hostel.edit', compact('pageTitle', 'hostel'));
    }

    function update(HostelRequest $request, $id)
    {
        $hostel = Hostel::with('hostel_images')->findOrFail($id);
        if (count($request->facilities) != count($request->icons)) {
            $notify[] = ['error', 'Some data are missing'];
            return back()->withNotify($notify);
        }

        $purifier = new \HTMLPurifier();
        $hostel->user_id = auth()->user()->id;
        $hostel->user_type = "user";
        $hostel->name = $request->name;
        $hostel->hostel_rules = $purifier->purify($request->hostel_rules);
        $hostel->facilities = $request->facilities;
        $hostel->icons = $request->icons;
        $hostel->address = $request->location;
        $hostel->city = $request->city_input;
        $hostel->state = $request->state_input;
        $hostel->country = $request->country_input;
        $hostel->latitude = $request->lat_input;
        $hostel->longitude = $request->lon_input;
        $hostel->description = $purifier->purify($request->description);
        $hostel->status = $hostel->status;
        $hostel->save();
        if ($request->hasFile('images')) {
            try {
                foreach ($request->images as $img) {
                    $hostel_image = new HostelImage();
                    $old =  $hostel_image->image;
                    $hostel_image->user_id = auth()->id();
                    $hostel_image->hostel_id = $hostel->id;
                    $hostel_image->path = '/' . date("Y") . '/' . date("m") . '/';
                    $hostel_image->image = fileUploader($img, getFilePath('hostel') . $hostel_image->path, getFileSize('hostel'));
                    $hostel_image->save();
                }

            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'Hostel Update successfully'];
        return back()->withNotify($notify);
    }


    function delete($id)
    {
        $pageTitle = 'Delete-Hostel';
        $hostel = Hostel::with('hostel_images', 'rooms')->where('id', $id)->first();
        $hostel_image = HostelImage::where('hostel_id', $id)->get();
        foreach ($hostel_image as $img) {
            fileManager()->removeFile(getFilePath('hostel') . '/' . $img->path . $img->image);
        }
        fileManager()->removeFile(getFilePath('hostel') . $hostel_image->first()->path . '/thumb_' . $hostel_image->first()->image);
        $hostel->hostel_images->each->delete();
        $rooms = Room::where('hostel_id', $id)->get();
        foreach ($rooms as $img) {
            fileManager()->removeFile(getFilePath('room') . '/' . $img->image);
        }
        $hostel->rooms->each->delete();
        $hostel->delete();
        $notify[] = ['success', 'Hostel Delete successfully'];
        return back()->withNotify($notify);
    }

    public function hostelImageDelete(Request $request)
    {
        try {
            $hostel_image = HostelImage::findOrFail($request->id);
            fileManager()->removeFile(getFilePath('hostel') . '/' . $hostel_image->path . $hostel_image->image);
            $hostel_image->delete();
            $data = [
                'status' => "success",
                'message' => "image delete successfully",
            ];
            return response()->json($data);
        } catch (\Exception $exp) {
            $notify[] = ['error', 'Couldn\'t delete your image'];
            return back()->withNotify($notify);
        }
    }
}
