<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function createdBy(){
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function tag(){
        return $this->belongsTo(ProductTag::class, "product_tag_id", "id");
    }

    public function comments()
    {
        return $this->hasMany(ProductComment::class, 'product_id', 'id')->orderBy("created_at", "DESC");
    }

}
