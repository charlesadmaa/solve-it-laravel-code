<?php

namespace App\Http\Resources;

use App\Models\CategoryForum;
use App\Models\ForumComment;
use App\Models\ForumCommentLastVisit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ForumResource extends JsonResource
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
            "featured_image" => isset($this->featured_image) ? asset('storage/forum/'.$this->featured_image) : NULL,
            "created_at" => Carbon::parse($this->created_at)->diffForHumans(),
            "active_comment_count" => $this->getActiveCommentCount(),
        ];
    }

    private function getActiveCommentCount(){
        $lastCommentView = ForumCommentLastVisit::where("forum_id", $this->id)->where("user_id", auth()->user()->id)->orderBy("created_at", "desc")->first();
        if(!$lastCommentView){
            return 0;
        }
        $lastCommentViewCount = ForumComment::where("created_at", ">=", $lastCommentView->created_at)->get()->count();
        return $lastCommentViewCount < 100 ? $lastCommentViewCount : "100+";
    }
}
