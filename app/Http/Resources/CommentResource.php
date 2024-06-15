<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // public function toArray(Request $request): array
    // {
    //     return [
    //         "id" => $this->id,
    //         "author" => new AuthorResource($this->author),
    //         "comment" => $this->comment,
    //         "parent_message_id" => $this->parent_id,
    //         "replies" => $this->replies,
    //         "created_at" => Carbon::parse($this->created_at)->diffForHumans()
    //     ];
    // }

    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "author" => new AuthorResource($this->author),
            "comment" => $this->comment,
            "parent_message_id" => $this->parent_id,
            "replies" => CommentResource::collection($this->repliesRecursive()),
            "created_at" => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }

}
