<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProductResource extends JsonResource
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
            "description" => $this->description,
            "tag" => new ProductTagSingleResource($this->tag),
            "featured_image" => isset($this->featured_image) ? asset('storage/product/'.$this->featured_image) : NULL,
            "createdBy" => new AuthorResource($this->createdBy),
            "amount" => number_format((int) $this->amount, 0),
            "currency" => $this->currency,
            "type" => $this->type,
            "is_featured" => $this->is_featured,
        ];
    }
}
