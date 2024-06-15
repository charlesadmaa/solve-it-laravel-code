<?php

namespace App\Http\Resources;

use App\Models\BlogLikes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            "is_featured" => $this->is_featured,
            "body" => $this->body,
            "featured_image" => asset('storage/blog/'.$this->featured_image),
            "likes" => $this->likes ? count($this->likes) : 0,
            "has_liked" => $this->activeUserHasLiked($this->blog_id, auth()->user()->id),
            "comments" => $this->comments ? count($this->comments) : 0,
            "created_at" => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }

    public function activeUserHasLiked($blogId, $userId){
        if(BlogLikes::where('blog_id', $blogId)->where("user_id", $userId)->exists()){
            return true;
        } else {
            return false;
        }
    }
}
