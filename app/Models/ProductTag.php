<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;

    public function createdBy(){
        return $this->belongsTo(User::class, "created_by_id", "id");
    }

    public function products(){
        return $this->hasMany(Product::class, "product_tag_id", "id");
    }
}
