<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'throttle:60,1'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify-user', [AuthController::class, 'verifyUser']);
    Route::post('verify-otp-code', [AuthController::class, 'verifyOtpCode']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('check', [AuthController::class, 'check']);

    Route::get('get-departments', [AuthController::class, 'getDepartment']);
    Route::get('get-schools', [AuthController::class, 'getSchools']);
    Route::get('get-levels', [AuthController::class, 'getLevels']);
    Route::get('get-user-interests', [AuthController::class, 'getUserInterests']);

    ##Undone
    Route::get('get-user-type', [AuthController::class, 'getUserType']);

});

Route::group(['middleware' => 'auth:api'], function(){

    ##Undone
    Route::group(['prefix' => 'dashboard'], function(){
        Route::get('get-dashboard', [DashboardController::class, 'getDashboard']);
        Route::get('get-dashboard-category', [DashboardController::class, 'getDashboardCategory']);
        Route::get('category/{categoryId}', [DashboardController::class, 'getCategory']);
        Route::get('blog/{blogId}', [DashboardController::class, 'getBlog']);
        Route::post('blog/like/{blogId}', [DashboardController::class, 'likeBlog']);
        Route::post('blog/comment/{blogId}', [DashboardController::class, 'commentBlog']);
        Route::get('blog/comment/{blogId}', [DashboardController::class, 'getCommentBlog']);
    });

    Route::group(['prefix' => 'account'], function(){
        Route::post('change-password', [ChangePasswordController::class, 'changePassword']);

        Route::post('user-update-verification', [UserVerificationController::class, 'verification']);
        Route::post('user-verification-otp', [UserVerificationController::class, 'verificationOtp']);

        Route::get('get-user-interest', [UserAccountController::class, 'getInterest']);
        Route::post('update-profile', [UserAccountController::class, 'updateProfile']);
        Route::post('update-user-interest', [UserAccountController::class, 'updateInterest']);

        Route::post('get-user-notifications', [NotificationController::class, 'getNotifications']);
        Route::post('delete-user-notifications', [NotificationController::class, 'deleteNotifications']);
    });

    Route::group(['prefix' => 'forum'], function(){
        Route::post('create', [ForumController::class, 'createForum']);
        Route::get('all', [ForumController::class, 'getAllForum']);
        Route::get('my-discussion', [ForumController::class, 'getForummyDiscussion']);
        Route::get('single/{forumId}', [ForumController::class, 'getSingleForum']);
        Route::post('create-comment/{forumId}', [ForumController::class, 'createForumComment']);
        Route::get('get-comment/{forumId}', [ForumController::class, 'getForumComment']);
        Route::post('create-category', [ForumController::class, 'createForumCategory']); // Admin creates Category
        Route::get('get-all-category', [ForumController::class, 'getAllForumCategory']);
        Route::get('get-single-category/{forumCategoryId}', [ForumController::class, 'getSingleForumCategory']);
    });

    Route::group(['prefix' => 'listing'], function(){
        Route::post('create', [ProductController::class, 'createListing']);
        Route::get('get-create-listing-resources', [ProductController::class, 'getCreateListingResources']);
        Route::get('all', [ProductController::class, 'getAllListing']);
        Route::get('single/{listingId}', [ProductController::class, 'getSingleListing']);
        Route::get('all-own', [ProductController::class, 'getAllOwnListing']);
        Route::post('filtered', [ProductController::class, 'getFilteredProduct']);
        Route::get('get-listing-tags', [ProductController::class, 'getListingTag']);
        Route::get('get-single-tag/{tagId}', [ProductController::class, 'getSingleTag']);
        Route::post('create-comment', [ProductController::class, 'createListingComment']);
        Route::post('reply-comment', [ProductController::class, 'replyListingComment']);
        Route::get('get-listing-comment/{listingId}', [ProductController::class, 'getListingComment']);
        Route::get('get-single-comment/product-id/{productId}/comment-id/{commentId}', [ProductController::class, 'getSingleProductComment']);
        Route::post('react-single-comment/{productCommentId}', [ProductController::class, 'reactSingleProductComment']);
    });

    Route::group(['prefix' => 'notification'], function(){
        Route::get('all-own', [NotificationMessageController::class, 'getAllOwnNotificationMessages']);
    });

});

Route::group(['middleware' => 'api', 'prefix' => 'admin'], function () {
    Route::get('/check', [AuthController::class, 'check']); //authUser
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
