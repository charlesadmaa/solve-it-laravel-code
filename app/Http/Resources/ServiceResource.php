<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            "description" => $this->description,
            "tag" => new ProductTagSingleResource($this->tag),
            "featured_image" => isset($this->featured_image) ? asset('storage/product/'.$this->featured_image) : NULL,
            "createdBy" => new AuthorResource($this->createdBy),
            "amount" => number_format((int) $this->amount, 0),
            "currency" => $this->currency,
            "is_featured" => $this->is_featured,
        ];
    }
}
