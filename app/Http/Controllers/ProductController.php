<?php

namespace App\Http\Controllers;

use App\Helpers\MarketPlaceType;
use App\Http\Resources\AllOwnProductResource;
use App\Http\Resources\ProductSingleResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SingleProductTagResource;
use App\Models\ProductCommentLike;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ErrorStatus;
use App\Helpers\SuccessStatus;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductTagResource;
use App\Http\Resources\ProductCommentResource;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\ProductTag;
use App\Models\ProductComment;
use App\Models\NotificationMessage;

class ProductController extends Controller
{
    public function getAllListing(){
        $products = Product::where("type", "product")->orderBy("created_at", "DESC")->paginate(10);
        $services = Product::where("type", "service")->orderBy("created_at", "DESC")->paginate(10);
        return response()->json([SuccessStatus::DATA => [
            "products" => ProductResource::collection($products),
            "services" => ServiceResource::collection($services),
        ]]);
    }

    public function getAllOwnListing()
    {
        $items = Product::where("created_by_id", auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return response()->json([SuccessStatus::DATA => [
            AllOwnProductResource::collection($items),
        ]]);
    }

    public function getFilteredProduct(Request $request)
    {
        $tagIds = $request->tagIds;
        $minPrice = $request->minPrice;
        $maxPrice = $request->maxPrice;
        $duration = $request->duration;

        $currentDate = now(); //date now
        $startOfWeek = $currentDate->startOfWeek()->toDateString(); // Start of the current week
        $endOfWeek = $currentDate->endOfWeek()->toDateString(); // End of the current week

        $productsQuery = Product::where('id', '>', 1);

        if (!empty($tagIds)) {
            $productsQuery->whereIn('product_tag_id', $tagIds);
        }

        if (!empty($duration)) {
            if ($duration == 'newest') {
                $productsQuery->whereDate('created_at', '>=', $startOfWeek)->whereDate('created_at', '<=', $endOfWeek);
            }
            if ($duration == 'older') {
                $productsQuery->whereDate('created_at', '<', $startOfWeek);
            }
        }

        if (!empty($minPrice) && !empty($maxPrice)) {
            $productsQuery->whereBetween('amount', [$minPrice, $maxPrice]);
        }

        return response()->json([
            SuccessStatus::DATA => [
                "products" => ProductResource::collection($productsQuery->paginate(10)),
            ],
        ]);

    }

    public function getCreateListingResources(Request $request)
    {
        $productTag = ProductTag::orderBy("created_at", "DESC")->get();
        return response()->json([SuccessStatus::DATA =>
            [
                "tags" => ProductTagResource::collection($productTag),
            ]
        ]);
    }

    public function createListing(Request $request)
    {
        $rules = array(
            'title' => 'required|string|min:2',
            'description' => 'required|string|max:255',
            'featured_image' => 'required|mimes:jpg,png,jpeg,webp',
            'amount' => 'required|numeric',
            'product_tag_id' => 'required|integer',
            'location' => 'required|string',
            'phone' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'type' => 'required|string',
        );
        $messages = [
            'title.required' => '* Your title is required',
            'title.string' => '* Invalid Characters',
            'title.min' => '* This title is too short',

            'description.required' => '* Your title is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Must not be morethan 255 characters',

            'featured_image.required' => '* Your product image is required',
            'featured_image.mimes' => '* Image format must be jpg, png, jpeg or webp',

            'amount.required' => '* The amount is required',
            'amount.numeric' => '* The amount must be a number',

            'product_tag_id.required' => '* Your tag must be selected',
            'product_tag_id.integer' => '* Invalid tag format',

            'location.required' => '* The location is required',
            'location.string' => '* Invalid string format',

            'type.string' => '* Invalid string format',
            'type.required' => '* Missing field (type), please provide the entity type, type must be (product or service)',


        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {
            $product = new Product();
            $product->title = $request->title;
            $product->description = $request->description;
            $product->created_by_id = auth()->user()->id;

            $product->amount = $request->amount;
            $product->product_tag_id = $request->product_tag_id;
            $product->phone = $request->phone;
            $product->whatsapp = $request->whatsapp;
            $product->type = MarketPlaceType::tryFrom($request->type) ?? MarketPlaceType::STATE_PRODUCT;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('product/', 'png', $request->file('featured_image'));
            } else {
                $image_name = 'default.png';
            }
            $product->featured_image = $image_name;
            $product->save();

            return response()->json([SuccessStatus::DATA => new ProductResource($product)]);
        }
    }

    public function getSingleListing($listingId){
        $product = Product::where("id", $listingId)->first();
        if(!$product){
            return response()->json([SuccessStatus::NOTFOUND => null], 404);
        }
        return response()->json([SuccessStatus::DATA => new ProductSingleResource($product)]);
    }

    public function getListingTag(){
        $productTag = ProductTag::orderBy("created_at", "DESC")->get();
        return response()->json([SuccessStatus::DATA => ProductTagResource::collection($productTag)]);
    }

    public function getSingleTag($tagId){
        $productTag = ProductTag::where("id", $tagId)->first();
        if(!$productTag){
            return response()->json([SuccessStatus::NOTFOUND => null], 404);
        }
        return response()->json([SuccessStatus::DATA => new SingleProductTagResource($productTag)]);
    }

    public function createListingComment(Request $request)
    {

        $rules = array(
            'message' => 'required|string',
        );
        $messages = [
            'message.required' => '* Message is required',
            'message.string' => '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {

            $listing = Product::where("id", $request->listing_id)->first();
            if(!$listing){
                return response()->json([SuccessStatus::NOTFOUND => null], 404);
            }

            $productComment = new ProductComment();
            $productComment->message = $request->message;
            $productComment->product_id = $listing->id;
            $productComment->created_by_id = auth()->user()->id;
            $productComment->save();

            $referencedObjects = ['product-'.$request->listing_id, 'comment-'.$productComment->id];

            //addNotification
            $notificationData = [
                'title' => auth()->user()->name . ' commented on your product',
                'created_by_id' => auth()->user()->id,
                'message' => $request->message,
                'referenced_objects' => json_encode($referencedObjects), // Convert array to JSON string
                'type' => 'comment',
                'referenced_user_id' => $listing->created_by_id,
                'featured_image' => auth()->user()->avatar,
            ];
            Helpers::addNotification($notificationData);

            return response()->json([SuccessStatus::DATA => new ProductCommentResource($productComment)]);
        }

    }

    public function replyListingComment(Request $request){

        $rules = array(
            'message' => 'required|string',
            'parent_comment_id' => 'required|string',
            'listing_id' => 'required|string',
        );
        $messages = [
            'message.required' => '* Message is required',
            'message.string' => '* Invalid Characters',

            'parent_comment_id.required' => '* Message is required',
            'parent_comment_id.string' => '* ParentCommentID Character is invalid',

            'listing_id.required' => '* List ID is required',
            'listing_id.string' => '* ListID Character is invalid',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {

            $listing = Product::where("id", $request->listing_id)->first();

            if(!$listing){
                return response()->json([SuccessStatus::NOTFOUND => null], 404);
            }


            $comment = new ProductComment();
            $comment->message = $request->message;
            $comment->product_id = $listing->id;
            $comment->parent_id = $request->parent_comment_id;
            $comment->created_by_id = auth()->user()->id;
            $comment->save();

            $referencedObjects = ['product-'.$listing->id, 'comment-'.$comment->id];

            //addNotification
            $notificationData = [
                'title' => auth()->user()->name . ' commented on your product',
                'created_by_id' => auth()->user()->id,
                'message' => $request->message,
                'referenced_objects' => json_encode($referencedObjects), // Convert array to JSON string
                'type' => 'comment',
                'referenced_user_id' => $listing->created_by_id,
                'featured_image' => auth()->user()->avatar,
            ];
            Helpers::addNotification($notificationData);

            return response()->json([SuccessStatus::DATA => new ProductCommentResource($comment)]);
        }

    }

    public function getListingComment($listingId){
        $listing = Product::where('id',$listingId)->first();
        $listingComments = ProductComment::where("product_id", $listing->id)->whereNull("parent_id")->orderBy("created_at", "DESC")->paginate(10);
        return response()->json([SuccessStatus::DATA => [
            "comments" => ProductCommentResource::collection($listingComments),
        ]]);
    }

    public function getSingleProductComment($productId, $commentId){
        $productComment = ProductComment::where("product_id", $productId)->where("id", $commentId)->first();
        if(!$productComment){
            return response()->json([SuccessStatus::NOTFOUND => null], 404);
        }
        return response()->json([SuccessStatus::DATA => new ProductCommentResource($productComment)]);
    }


    public function reactSingleProductComment($listingCommentId) {
        $item = ProductCommentLike::where("product_comment_id", $listingCommentId)->where("user_id", auth()->user()->id)->first();

        if($item){
            $item->delete();
        } else {
            $likeComment = new ProductCommentLike();
            $likeComment->user_id = auth()->user()->id;
            $likeComment->product_comment_id = $listingCommentId;
            $likeComment->save();
        }

        $totalLikes = ProductCommentLike::where("product_comment_id", $listingCommentId)->get()->count();

        return response()->json([SuccessStatus::DATA => [
            "likesCount" => $totalLikes,
        ]]);
    }
}
