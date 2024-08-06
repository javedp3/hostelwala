<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\CommunityLike;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Community extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    } 
    
    public function community_likes(){
        return $this->hasMany(CommunityLike::class,);
    }

    public function commentCount(){
        return $this->comments->count();
    }

   
}
