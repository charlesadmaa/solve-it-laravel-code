<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ForumCommentResource extends JsonResource
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
            "message" => isset($this->message) ? $this->message : NULL,
            "file" => isset($this->file) ? asset('storage/forum/comment/'.$this->file) : NULL,
            "file_type" => isset($this->file_type) ? $this->file_type : NULL,
            "forum_id" => $this->forum_id,
            "createdBy" => new AuthorResource($this->createdBy),
            "created_at" => Carbon::parse($this->created_at)->diffForHumans(),
            "created_at_datetime" => $this->created_at
        ];
    }
}
