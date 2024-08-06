<?php

namespace App\Models;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Deposit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;
    protected $with = ['user'];
    
    public function user()
    {
        return $this->belongsTo(User::class,'owner_id','id');
    }
    
    public function owner()
    {
        return $this->belongsTo(User::class,'owner_id','id');
    }
    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class,'tenant_id','id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }
}
