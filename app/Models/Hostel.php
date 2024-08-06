<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Admin;
use App\Models\Review;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use App\Models\HostelImage;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hostel extends Model
{
    use HasFactory;

    protected $with = ['rooms'];
    protected $casts = [
        'facilities' => 'object',
        'icons' => 'object',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function hostel_images()
    {
        return $this->hasMany(HostelImage::class);
    }

    public function scopePending()
    {
        return $this->where('status', '=', 0);
    }

    public function scopeActive()
    {
        return $this->where('status', '=', 1);
    }

    public function lowPrice()
    {
        return $this->rooms->min('rent_per_day');
    }

    public function highPrice()
    {
        return $this->rooms->max('rent_per_day');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'hostel_id', 'id');
    }

    public function checkBookingData($room_id,$checkInDate,$checkOutDate)
    {

        $checkInDate = Carbon::parse($checkInDate);
        $checkOutDate = Carbon::parse($checkOutDate);
        
        $bookings = $this->booking()->where('room_id',$room_id)->whereIn('status', [1,2])->get();

        foreach ($bookings as $data) {
            $allBooking = [];
            $startDate = Carbon::parse($data->from_date);
            $endDate = Carbon::parse($data->to_date);
            // Add booked dates to $allBooking
            while ($startDate->lte($endDate)) {
                $allBooking[$data->id][] = $startDate->format('Y-m-d');
                $startDate->addDay();
            }

            $newBooking = [];
            $period = CarbonPeriod::create($checkInDate, $checkOutDate);
            foreach ($period as $date) {
                $newBooking[] = $date->format('Y-m-d');
            }
            $overlap[$data->id] = array_intersect($allBooking[$data->id], $newBooking);
        }

        $result = [];
        foreach ($overlap as $key => $value) {
            if (!empty($value)) {
                $result[] = $key;
            }
        }
       return $this->checkRoom($result) ;
    }

    public function checkRoom($data)
    {
        $rooms_or_beds = 0;
        foreach ($data as $value) {
            $bookings = Booking::with('user')->where('id', $value)->get();
            $bookings->each(function (object $item, int $key) use(&$rooms_or_beds) {
                if ($item->room_id) {
                    $rooms_or_beds += $item->rooms_or_beds;
                }
            });
        }
        
        return $rooms_or_beds;
    }

    public function pendingRoomCount()
    {
        return $this->rooms->where('status', 0)->count();
    }
}
