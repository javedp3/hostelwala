<?php

namespace App\Models;

use App\Models\CommentLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment_likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    
    public function existLike()
    {
        return $this->comment_likes->where('user_id',auth()->id())->first();
    }
}
