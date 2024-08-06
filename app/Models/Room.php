<?php

namespace App\Models;

use App\Models\Hostel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    public function hostel(){
      return $this->belongsTo(Hostel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopePending()
    {
        return $this->where('status', '=', 0);
    }

    public function scopeActive()
    {
        return $this->where('status', '=', 1);
    }

}
