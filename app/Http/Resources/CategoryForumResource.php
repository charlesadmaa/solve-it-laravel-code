<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryForumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->category->title,
            "featured_image" => asset("storage/blog-category". $this->category->featured_image),
            "created_by_id" => $this->category->authour,
            "forum_category_id" => $this->category->id,
        ];
    }
}
