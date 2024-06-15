<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public function author(){
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function comments(){
        return $this->hasMany(BlogComment::class, "blog_id", "id");
    }

    public function likes(){
        return $this->hasMany(BlogLikes::class, "blog_id", "id");
    }

    public function categories(){
        return $this->belongsToMany(BlogCategories::class, CategoryBlog::class, 'blog_id', 'category_id', 'id');
    }
}
