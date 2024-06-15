<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleBlogPostResource extends JsonResource
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
            "title" => $this->title,
            "body" => $this->body,
            "is_featured" => $this->is_featured,
            "featured_image" => asset('storage/blog/'.$this->featured_image),
            "author" => new AuthorResource($this->author),
            'likes' => count($this->likes),
            'comments_total' => count($this->comments),
            'comments' => CommentResource::collection($this->comments)
        ];
    }
}
