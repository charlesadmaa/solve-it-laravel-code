<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;

    public function createdBy(){
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    public function replies()
    {
        return $this->hasMany(ProductComment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ProductComment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'product_comment_likes', 'product_comment_id', 'user_id')->withTimestamps();
    }

    // public function unlikesCount()
    // {
    //     //$comment = ProductComment::find($commentId);
    //     $comment = $this;

    //     $totalLikes = $comment->likes()->count();
    //     $totalComments = $comment->replies()->count(); // Assuming replies are also considered as comments

    //     $unlikeCount = $totalComments - $totalLikes;
    //     return $unlikeCount;
    // }
}
