<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    public function author(){
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    public function repliesRecursive()
    {
        $replies = $this->replies()->with('author')->get();
        
        foreach ($replies as $reply) {
            $reply->replies = $reply->repliesRecursive();
        }
        
        return $replies;
    }
}
