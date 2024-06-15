<?php

namespace App\Http\Resources;

use App\Models\ProductComment;
use App\Models\ProductCommentLike;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentRepliesResource extends JsonResource
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
            "message" => $this->message,
            "product_id" => $this->product_id,
            "createdBy" => new AuthorResource($this->createdBy),
            "replies" => CommentRepliesResource::collection($this->getCommentReplies()), // Need to be update to paginate record too
            "created_at" => Carbon::parse($this->created_at)->diffForHumans(),
            "parent_id" => $this->parent_id,
            "has_liked" => $this->getLikeStatus($this->id)
        ];
    }

    private function getCommentReplies(){
        $replies = ProductComment::where("parent_id", $this->id)->where("product_id", $this->product_id)->orderBy("created_at", "DESC")->paginate(10);
        return CommentRepliesResource::collection($replies);
    }

    private function getLikeStatus($productCommentId){
        $commentIsLiked = ProductCommentLike::where("user_id", auth()->user()->id)->where("product_comment_id", $productCommentId)->first();
        return $commentIsLiked ? 1 : 0;
    }
}
