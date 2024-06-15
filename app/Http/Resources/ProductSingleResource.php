<?php

namespace App\Http\Resources;

use App\Helpers\SuccessStatus;
use App\Models\Product;
use App\Models\ProductComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSingleResource extends JsonResource
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
            "phone" => $this->phone,
            "whatsapp" => $this->whatsapp,
            "is_featured" => $this->is_featured,
            "created_at" => Carbon::parse($this->created_at)->diffForHumans(),
            "comment" => $this->getListingComments()
        ];
    }

    private function getCommentReplies(){
        return ProductComment::where("parent_id", $this->id)->get();
    }

    private function getListingComments(){
        $listingComments = ProductComment::where("product_id", $this->id)->whereNull("parent_id")->paginate(10);
        return ProductCommentResource::collection($listingComments);
    }
}
