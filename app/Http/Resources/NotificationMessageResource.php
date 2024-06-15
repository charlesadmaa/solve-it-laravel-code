<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NotificationMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $authorResource = new AuthorResource($this->createdBy);
        return [
            "id" => $this->id,
            "title" => $this->title,
            "createdBy" => $authorResource,
            "message" => $this->message,
            "referenced_objects" => $this->referenced_objects,
            "type" => $this->type,
            "referenced_user_id" => $this->referenced_user_id,
            "featured_image" => isset($this->featured_image) ? asset("storage/images/users/".$authorResource->avatar) : NULL,
            "created_at" => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
