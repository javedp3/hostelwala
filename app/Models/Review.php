<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
