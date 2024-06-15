<?php

namespace App\Http\Controllers;

use App\Helpers\ErrorStatus;
use App\Helpers\SuccessStatus;
use App\Http\Resources\BlogCategoryResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\SingleBlogPostResource;
use App\Models\Blog;
use App\Models\BlogCategories;
use App\Models\BlogComment;
use App\Models\BlogInterestTag;
use App\Models\BlogLikes;
use App\Models\CategoryBlog;
use App\Models\User;
use App\Models\UserInterests;
use App\Models\NotificationMessage;
use App\Services\Api\TermiApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function getDashboard(){
        $blog = $this->getUserInterest();
        return response()->json([SuccessStatus::DATA => [
            "blog" => BlogResource::collection($blog),
        ]]);
    }

    private function getUserInterest(){
        $userInterest = UserInterests::where("user_id", auth()->user()->id)->pluck("interest_id");
        $blogInterest = BlogInterestTag::whereIn('interest_id', $userInterest)->pluck("blog_id");
        return Blog::whereIn("id", $blogInterest)->orderBy("created_at", "Desc")->paginate(30);
    }

    public function getDashboardCategory(){
        $categories = BlogCategories::orderby("created_at", "desc")->limit(5)->get();

        $formattedCategories = [];

        $formattedCategories[] = [
            "id" => 0,
            "title" => "For you"
        ];

        foreach ($categories as $item){
            $formattedCategories[] = [
                "id" => $item->id,
                "title" => $item->title
            ];
        }

        return response()->json([SuccessStatus::DATA => [
            "categories" => BlogCategoryResource::collection($formattedCategories)
        ]]);
    }

    public function getCategory($categoryId){
        if($categoryId == "0"){
            $blog = $this->getUserInterest();
        } else {
            $blogCategory = CategoryBlog::where('category_id', $categoryId)->get()->pluck("blog_id");
            $blog = Blog::whereIn("id", $blogCategory)->orderby("created_at", "desc")->paginate(30);
        }
        return response()->json([SuccessStatus::DATA => [
            "blog" => BlogResource::collection($blog),
        ]]);
    }

    public function getBlog($blogId){
        $blog = Blog::where("id", $blogId)->first();
        if(!$blog){
            return response()->json([SuccessStatus::NOTFOUND => null], 404);
        }
        return response()->json([SuccessStatus::DATA => new SingleBlogPostResource($blog)]);
    }

    public function likeBlog($blogId){
        $blog = Blog::where("id", $blogId)->first();
        if(!$blog){
            return response()->json([ErrorStatus::ERROR => null], 404);
        }

        $data = BlogLikes::where('user_id', auth()->user()->id)->where("blog_id", $blogId)->first();
        if(!$data){
            $blogLike = new BlogLikes();
            $blogLike->user_id = auth()->user()->id;
            $blogLike->blog_id =  $blogId;
            $blogLike->save();
            $result = 1;
        } else {
            $data->delete();
            $result = 0;
        }

        return response()->json([SuccessStatus::DATA => [
            "success" => $result
        ]]);

    }

    public function commentBlog(Request $request, $blogId){

        $rules = [
            'comment' => 'required|string',
        ];

        $messages = [
            'comment.required' => 'This field is required',
            'comment.string' => 'Please enter a valid input',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }  else {

            $blog = Blog::where("id", $blogId)->first();
            if(!$blog){
                return response()->json([SuccessStatus::NOTFOUND => null], 404);
            }

            $blogComment = new BlogComment();
            $blogComment->user_id = auth()->user()->id;
            $blogComment->blog_id =  $blogId;
            $blogComment->comment =  $request->comment;
            $blogComment->parent_id = isset($request->parent_comment_id) ? $request->parent_comment_id : NULL;
            $blogComment->save();

            return response()->json([SuccessStatus::DATA => new CommentResource($blogComment)]);

        }
    }

    //blog comments - all
    public function getCommentBlog($blogId){
        $blog = Blog::where('id', $blogId)->first();
        $blogComments = $blog->comments;
        return response()->json([SuccessStatus::DATA => [
            "comments" => CommentResource::collection($blogComments),
        ]]);
    }
}

