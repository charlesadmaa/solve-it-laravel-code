<?php

namespace App\Http\Controllers;

use App\Models\ForumCommentLastVisit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ErrorStatus;
use App\Helpers\SuccessStatus;
use App\Http\Resources\ForumResource;
use App\Http\Resources\ForumCategoryResource;
use App\Http\Resources\ForumCommentResource;
use App\Models\Forum;
use App\Models\ForumCategory;
use App\Models\CategoryForum;
use App\Models\ForumComment;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getAllForum(){
        $forums = Forum::orderBy("created_at", "desc")->paginate(10);
        $forumCategory = ForumCategory::orderBy("created_at", "desc")->limit(10)->get();

        return response()->json([SuccessStatus::DATA => [
            "categories" => ForumCategoryResource::collection($forumCategory),
            "forums" => ForumResource::collection($forums),
        ]]);
    }

    public function getForummyDiscussion(Request $request){
        $forumCommentIds = ForumComment::where("created_by_id", auth()->user()->id)->orderBy("created_at", "desc")->pluck("forum_id");
        $forums = Forum::whereIn("id", array_unique($forumCommentIds->toArray()))->orderBy("created_at", "desc")->get();
        $forumCategory = ForumCategory::orderBy("created_at", "desc")->limit(10)->get();

        return response()->json([SuccessStatus::DATA => [
            "categories" => ForumCategoryResource::collection($forumCategory),
            "forums" => ForumResource::collection($forums),
        ]]);
    }

    public function createForum(Request $request)
    {
        $rules = array(
            'title' => 'required|string|min:2',
            'description' => 'required|string|max:255',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp',
        );
        $messages = [
            'title.required' => '* Your title is required',
            'title.string' => '* Invalid Characters',
            'title.min' => '* This title is too short',

            'description.required' => '* Your title is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Must not be morethan 255 characters',

        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {
            $forum = new Forum();
            $forum->title = $request->title;
            $forum->description = $request->description;
            $forum->created_by_id = auth()->user()->id;

            $forum->save();

            if ($request->forum_category_id) {
                foreach ($request->forum_category_id as $id) {
                    $categoryForum = new CategoryForum();
                    $categoryForum->forum_id = $forum->id;
                    $categoryForum->forum_category_id = $id;
                    $categoryForum->save();
                }
            }
            return response()->json([SuccessStatus::DATA => new ForumResource($forum)]);
        }
    }

    public function createForumCategory(Request $request)
    {
        $rules = array(
            'title' => 'required|string|min:2',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp',
        );
        $messages = [
            'title.required' => '* Your title is required',
            'title.string' => '* Invalid Characters',
            'title.min' => '* This title is too short',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {
            $forumCategory = new ForumCategory();
            $forumCategory->title = $request->title;
            $forumCategory->created_by_id = auth()->user()->id;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('forum/category/', 'png', $request->file('featured_image'));
            } else {
                $image_name = 'default.png';
            }
            $forumCategory->featured_image = $image_name;
            $forumCategory->save();

            return response()->json([SuccessStatus::DATA => new ForumCategoryResource($forumCategory)]);
        }
    }

    public function getSingleForum($forumId){
        $forum = Forum::where("id", $forumId)->first();
        if(!$forum){
            return response()->json([SuccessStatus::NOTFOUND => null], 404);
        }

        $this->updateCommentLastVisit($forum);

        $comments = ForumComment::where('forum_id', $forumId)->orderBy('created_at', "desc")
            ->paginate(30)
            ->groupBy(function ($query) {
                return Carbon::parse($query->created_at)->format('Y-m-d');
            })->map(function ($query) {
                return $query->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'message' => $item->message,
                        'attachment' => $item->file ? asset('storage/forum/' . $item->file) : null,
                        'created_by' => [
                            'id' => $item->sender->id,
                            'name' => $item->sender->name,
                            'avatar' => asset('storage/images/users/' . $item->sender->avatar)
                        ],
                        'created_at' => \Carbon\Carbon::parse($item->created_at)->format('M-d-y H:i:s')
                    ];
                });
            });

        return response()->json([SuccessStatus::DATA =>
            [
                "id" => $forum->id,
                "title" => $forum->title,
                "description" => $forum->description,
                "featured_image" => isset($forum->featured_image) ? asset('storage/forum/'.$forum->featured_image) : NULL,
                "created_at" => Carbon::parse($forum->created_at)->diffForHumans(),
                "comments" => $comments
            ]

        ]);
    }

    private  function updateCommentLastVisit($forum){
        $lastForumCommentVisit = ForumCommentLastVisit::where("forum_id", $forum->id)->where("user_id", auth()->user()->id)->first();
        if(!$lastForumCommentVisit){
            $lastForumCommentVisit = new ForumCommentLastVisit();
            $lastForumCommentVisit->user_id = auth()->user()->id;
            $lastForumCommentVisit->forum_id = $forum->id;
        }
        $lastForumCommentVisit->created_at = now();
        $lastForumCommentVisit->updated_at = now();
        $lastForumCommentVisit->save();

    }

    public function getAllForumCategory(){
        $forumCategory = ForumCategory::all();
        return response()->json([SuccessStatus::DATA => [
            ForumCategoryResource::collection($forumCategory)
        ]]);
    }


    public function getSingleForumCategory($forumCategoryId){
        $forumCategory = ForumCategory::where("id", $forumCategoryId)->first();
        if(!$forumCategory){
            return response()->json([SuccessStatus::NOTFOUND => null], 404);
        }
        return response()->json([SuccessStatus::DATA => new ForumCategoryResource($forumCategory)]);
    }


    public function createForumComment(Request $request, $forumId)
    {
        $forum = Forum::where("id", $forumId)->first();
        if(!$forum){
            return response()->json([SuccessStatus::NOTFOUND => null], 404);
        }
        $rules = array(
            'message' => 'nullable|string',
            'file' => 'nullable',
        );
        $messages = [
            'message.required' => '* Your message is required',
            'message.string' => '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {
            $forumComment = new ForumComment();
            $forumComment->message = isset($request->message) ? $request->message : NULL;
            $forumComment->forum_id = $forumId;
            $forumComment->created_by_id = auth()->user()->id;

            // Check if a file is present in the request
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Get the file extension
                $extension = $file->getClientOriginalExtension();

                // Determine the file type based on the extension
                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $fileType = 'image';
                    $forumComment->file  = Helpers::upload('forum/comment/', 'png', $request->file('file'));
                } elseif (in_array(strtolower($extension), ['mp4', 'mov', 'avi', 'wmv'])) {
                    $fileType = 'video';
                    $forumComment->file =  $request->file->store('forum/comment', 'public');
                } else {
                    // Set a default file type or handle other types as needed
                    $fileType = 'other';
                }

                $forumComment->file_type = $fileType;
            }

            $forumComment->save();

            return response()->json([SuccessStatus::DATA => new ForumCommentResource($forumComment)]);
        }

    }

    public function getForumComment($forumId){
        $forum = Forum::where('id', $forumId)->first();
        $forumComments = $forum->comments;
        return response()->json([SuccessStatus::DATA => [
            "comments" => ForumCommentResource::collection($forumComments),
        ]]);
    }
}
