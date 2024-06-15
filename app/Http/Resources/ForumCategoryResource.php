<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ForumCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            "id" => $this->id,
            "title" => $this->title,
            "featured_image" => isset($this->featured_image) ? asset('storage/forum/category/'.$this->featured_image) : NULL,
            "forums" => $this->forums,
            "createdBy" => new AuthorResource($this->createdBy),
            "created_at" => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
