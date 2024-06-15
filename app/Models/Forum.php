<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    use HasFactory;

    public function createdBy(){
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function categories()
    {
        return $this->belongsToMany(ForumCategory::class, 'category_forums', 'forum_id', 'forum_category_id');
    }

    public function comments()
    {
        return $this->hasMany(ForumComment::class, 'forum_id', 'id');
    }
}
