<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    public function createdBy(){
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function forums()
    {
        return $this->belongsToMany(Forum::class, 'category_forums', 'forum_category_id', 'forum_id');
    }
}
