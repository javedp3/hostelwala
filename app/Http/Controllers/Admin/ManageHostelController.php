<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Hostel;
use App\Models\Review;
use App\Models\HostelImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HostelRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class ManageHostelController extends Controller
{
    public function hostel_list(Request $request)
    {
        $pageTitle = 'Hostel-List';
        $hostel_list = $this->hostelData();
        return view('admin.hostel.list', compact('pageTitle', 'hostel_list'));
    }

    public function my_hostel_list(Request $request)
    {

        $pageTitle = 'My Hostel';
        $hostel_list = Hostel::with('user')
            ->where('user_id', auth('admin')->id())
            ->where('user_type', 'admin')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate());

        if ($request->search) {
            $hostel_list = Hostel::with('user')->where('user_type', 'admin')->where('name', 'like', "%$request->search%")->orderBy('id', 'desc')->paginate(getPaginate());
        }
        return view('admin.hostel.my_list', compact('pageTitle', 'hostel_list'));
    }


    public function add_hostel()
    {
        $pageTitle = 'Add-Hostel';
        return view('admin.hostel.add', compact('pageTitle'));
    }

    public function store(HostelRequest $request): RedirectResponse
    {
        $pageTitle = 'Create-Hostel';
        if(count($request->facilities) != count($request->icons)){
            $notify[] = ['error', 'Some data are missing'];
            return back()->withNotify($notify);
        }

        if(!($request->country_input || $request->state_input || $request->lat_input || $request->lon_input)){
            $notify[] = ['error', 'Please location select Perfectly'];
            return back()->withNotify($notify);
        }

        $hostel = new Hostel();
        $purifier = new \HTMLPurifier();
        $hostel->user_id = auth('admin')->id();
        $hostel->user_type = "admin";
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
        $hostel->status = 1;
        $hostel->save();
        if ($request->hasFile('images')) {
            try {
                foreach ($request->images as $index => $img) {
                    $hostel_image = new HostelImage();
                    $hostel_image->user_id = auth('admin')->id();
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
        return view('admin.hostel.edit', compact('pageTitle', 'hostel'));
    }

    function update(HostelRequest $request, $id)
    {
   
        if(count($request->facilities) != count($request->icons)){
            $notify[] = ['error', 'Some data are missing'];
            return back()->withNotify($notify);
        }

        $hostel = Hostel::with('hostel_images')->findOrFail($id);
        $purifier = new \HTMLPurifier();
        $hostel->user_id = auth('admin')->id();
        $hostel->user_type = "admin";
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
        $hostel->status = $hostel->status;
        $hostel->save();
        if ($request->hasFile('images')) {
            try {
                foreach ($request->images as $img) {
                    $hostel_image = new HostelImage();
                    $old =  $hostel_image->image;
                    $hostel_image->user_id = auth('admin')->id();
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
        $hostel = Hostel::with('hostel_images')->where('id', $id)->first();
        $hostel_image = HostelImage::where('hostel_id',$id)->get();
        foreach ($hostel_image as $img) {
            
            fileManager()->removeFile(getFilePath('hostel') . '/' . $img->path . $img->image);
        }
        fileManager()->removeFile(getFilePath('hostel') . $hostel_image->first()->path . '/thumb_' . $hostel_image->first()->image);
        $hostel->hostel_images->each->delete();
        $rooms = Room::where('hostel_id',$id)->get();
        foreach ($rooms as $img) {
            fileManager()->removeFile(getFilePath('room') . '/' . $img->image);
        }
        $hostel->rooms->each->delete();
        $hostel->hostel_images->each->delete();
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
    public function pending()
    {
        $pageTitle = 'Pending Hostels';
        $hostel_list = $this->hostelData('pending');
        return view('admin.hostel.list', compact('pageTitle', 'hostel_list'));
    }


    public function active()
    {
        $pageTitle = 'Active Hostels';
        $hostel_list = $this->hostelData('active');
        return view('admin.hostel.list', compact('pageTitle', 'hostel_list'));
    }

    public function hostelStatus(Request $request)
    {
        $hostel = Hostel::where('id', $request->id)->first();
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
                'message' => "Hostel status updated."
            ],
        );
    }

   
    protected function hostelData($scope = null)
    {
        if ($scope) {
            $hostels = Hostel::$scope();
        } else {
            $hostels = Hostel::query();
        }

        //search
        $request = request();
        if ($request->search) {
            $search = $request->search;
            $hostels  = $hostels->where(function ($hostel) use ($search) {
                $hostel->where('name', 'like', "%$search%");
            });
        }
        return $hostels->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
    }
  
    public function hostel_view($id)
    {
        $pageTitle = 'Booking Hostel';
        Session::forget("booking");
        Session::forget("coupon");
        $hostel = Hostel::with('hostel_images', 'rooms','reviews','user')->where('id', $id)->first();
        $reviews = Review::with('user')->where('hostel_id', $id)->paginate(getPaginate());

        $totalRating = $reviews->sum('rating');

        return view($this->activeTemplate . 'hostel.hostel-list-details', compact('pageTitle','hostel','reviews','totalRating'));
        

    }
    
}
