<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/clear-redis-cache', function () {
    $redisConnection = \Illuminate\Support\Facades\Redis::connection('default');
    $redisConnection->flushDB();
    dd("Redis Cache Cleared");
});


Route::get('/', function(){
    return redirect()->to(route('adminLogin'));
})->name('landingPage');



Route::group(['prefix' => 'admin'], function() {

    Route::middleware('guest')->group(function() {
        Route::get('/', function(){
            return redirect()->route("adminDashboard");
        });

        Route::get('login', [AdminController::class, 'adminLogin'])->name('adminLogin');
        Route::post('login', [AdminController::class, 'adminLoginPost'])->name('adminLoginPost');
    });

    Route::middleware(['auth:web', 'IsAdmin'])->group(function() {
        Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('adminDashboard');
        Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('AdminLogout');

        //user
        Route::get('/user', [AdminController::class, 'manageUser'])->name('manageUser');
        Route::get('/user/add-new', [AdminController::class, 'manageUserAdd'])->name('manageUserAdd');
        Route::post('/user/add-new', [AdminController::class, 'manageUserAddPost'])->name('manageUserAddPost');
        Route::get('/user/edit/{dataId}', [AdminController::class, 'manageUserEdit'])->name('manageUserEdit');
        Route::post('user/edit/{dataId}', [AdminController::class, 'manageUserEditPost'])->name('manageUserEditPost');
        Route::get('/user/delete/{dataId}', [AdminController::class, 'manageUserDelete'])->name('manageUserDelete');
        Route::get('/user/delete-multiple', [AdminController::class, 'manageUserDeleteMultiple'])->name('manageUserDeleteMultiple');


        //listing tags
        Route::get('/listing/tags', [AdminController::class, 'manageListingTag'])->name('manageListingTag');
        Route::get('/listing/tags/add-new', [AdminController::class, 'manageListingTagAdd'])->name('manageListingTagAdd');
        Route::post('/listing/tags/add-new', [AdminController::class, 'manageListingTagAddPost'])->name('manageListingTagAddPost');
        Route::get('/listing/tags/edit/{dataId}', [AdminController::class, 'manageListingTagEdit'])->name('manageListingTagEdit');
        Route::post('listing/tags/edit/{dataId}', [AdminController::class, 'manageListingTagEditPost'])->name('manageListingTagEditPost');
        Route::get('/listing/tags/delete/{dataId}', [AdminController::class, 'manageListingTagDelete'])->name('manageListingTagDelete');
        Route::get('/listing/tags/delete-multiple', [AdminController::class, 'manageListingTagDeleteMultiple'])->name('manageListingTagDeleteMultiple');


        //listing
        Route::get('/listing', [AdminController::class, 'manageListing'])->name('manageListing');
        Route::get('/listing/add-new', [AdminController::class, 'manageListingAdd'])->name('manageListingAdd');
        Route::post('/listing/add-new', [AdminController::class, 'manageListingAddPost'])->name('manageListingAddPost');
        Route::get('/listing/edit/{dataId}', [AdminController::class, 'manageListingEdit'])->name('manageListingEdit');
        Route::post('listing/edit/{dataId}', [AdminController::class, 'manageListingEditPost'])->name('manageListingEditPost');
        Route::get('/listing/delete/{dataId}', [AdminController::class, 'manageListingDelete'])->name('manageListingDelete');
        Route::get('/listing/delete-multiple', [AdminController::class, 'manageListingDeleteMultiple'])->name('manageListingDeleteMultiple');

        //forum
        Route::get('/forum', [AdminController::class, 'manageForum'])->name('manageForum');
        Route::get('/forum/add-new', [AdminController::class, 'manageForumAdd'])->name('manageForumAdd');
        Route::post('/forum/add-new', [AdminController::class, 'manageForumAddPost'])->name('manageForumAddPost');
        Route::get('/forum/edit/{dataId}', [AdminController::class, 'manageForumEdit'])->name('manageForumEdit');
        Route::post('forum/edit/{dataId}', [AdminController::class, 'manageForumEditPost'])->name('manageForumEditPost');
        Route::get('/forum/delete/{dataId}', [AdminController::class, 'manageForumDelete'])->name('manageForumDelete');
        Route::get('/forum/delete-multiple', [AdminController::class, 'manageForumDeleteMultiple'])->name('manageForumDeleteMultiple');

        //forum comments
        Route::get('/forum/comments', [AdminController::class, 'manageForumComment'])->name('manageForumComment');
        Route::get('/forum/comments/edit/{dataId}', [AdminController::class, 'manageForumCommentEdit'])->name('manageForumCommentEdit');
        Route::post('forum/comments/edit/{dataId}', [AdminController::class, 'manageForumCommentEditPost'])->name('manageForumCommentEditPost');
        Route::get('/forum/comments/add-new', [AdminController::class, 'manageForumCommentAdd'])->name('manageForumCommentAdd');
        Route::post('/forum/comments/add-new', [AdminController::class, 'manageForumCommentAddPost'])->name('manageForumCommentAddPost');
        Route::get('/forum/comments/delete/{dataId}', [AdminController::class, 'manageForumCommentDelete'])->name('manageForumCommentDelete');
        Route::get('/forum/comments/delete-multiple', [AdminController::class, 'manageForumCommentDeleteMultiple'])->name('manageForumCommentDeleteMultiple');

        //Dataset
        Route::get('/department', [AdminController::class, 'manageDepartment'])->name('manageDepartment');
        Route::get('/department/edit/{dataId}', [AdminController::class, 'manageDepartmentEdit'])->name('manageDepartmentEdit');
        Route::post('/department/edit/{dataId}', [AdminController::class, 'manageDepartmentEditPost'])->name('manageDepartmentEditPost');
        Route::get('/department/add-new', [AdminController::class, 'manageDepartmentAdd'])->name('manageDepartmentAdd');
        Route::post('/department/add-new', [AdminController::class, 'manageDepartmentAddPost'])->name('manageDepartmentAddPost');
        Route::get('/department/delete/{dataId}', [AdminController::class, 'manageDepartmentDelete'])->name('manageDepartmentDelete');
        Route::get('/department/delete-multiple', [AdminController::class, 'manageDepartmentDeleteMultiple'])->name('manageDepartmentDeleteMultiple');

        Route::get('/levels', [AdminController::class, 'manageLevels'])->name('manageLevels');
        Route::get('/levels/edit/{dataId}', [AdminController::class, 'manageLevelsEdit'])->name('manageLevelsEdit');
        Route::post('levels/edit/{dataId}', [AdminController::class, 'manageLevelsEditPost'])->name('manageLevelsEditPost');
        Route::get('/levels/add-new', [AdminController::class, 'manageLevelsAdd'])->name('manageLevelsAdd');
        Route::post('/levels/add-new', [AdminController::class, 'manageLevelsAddPost'])->name('manageLevelsAddPost');
        Route::get('/levels/delete/{dataId}', [AdminController::class, 'manageLevelsDelete'])->name('manageLevelsDelete');
        Route::get('/levels/delete-multiple', [AdminController::class, 'manageLevelsDeleteMultiple'])->name('manageLevelsDeleteMultiple');

        Route::get('/interest', [AdminController::class, 'manageInterest'])->name('manageInterest');
        Route::get('/interest/edit/{dataId}', [AdminController::class, 'manageInterestEdit'])->name('manageInterestEdit');
        Route::post('interest/edit/{dataId}', [AdminController::class, 'manageInterestEditPost'])->name('manageInterestEditPost');
        Route::get('/interest/add-new', [AdminController::class, 'manageInterestAdd'])->name('manageInterestAdd');
        Route::post('/interest/add-new', [AdminController::class, 'manageInterestAddPost'])->name('manageInterestAddPost');
        Route::get('/interest/delete/{dataId}', [AdminController::class, 'manageInterestDelete'])->name('manageInterestDelete');
        Route::get('/interest/delete-multiple', [AdminController::class, 'manageInterestDeleteMultiple'])->name('manageInterestDeleteMultiple');

        Route::get('/school', [AdminController::class, 'manageSchool'])->name('manageSchool');
        Route::get('/school/edit/{dataId}', [AdminController::class, 'manageSchoolEdit'])->name('manageSchoolEdit');
        Route::post('school/edit/{dataId}', [AdminController::class, 'manageSchoolEditPost'])->name('manageSchoolEditPost');
        Route::get('/school/add-new', [AdminController::class, 'manageSchoolAdd'])->name('manageSchoolAdd');
        Route::post('/school/add-new', [AdminController::class, 'manageSchoolAddPost'])->name('manageSchoolAddPost');
        Route::get('/school/delete/{dataId}', [AdminController::class, 'manageSchoolDelete'])->name('manageSchoolDelete');
        Route::get('/school/delete-multiple', [AdminController::class, 'manageSchoolDeleteMultiple'])->name('manageSchoolDeleteMultiple');

        Route::get('/blog/category', [AdminController::class, 'manageCategory'])->name('manageCategory');
        Route::get('/blog/category/edit/{dataId}', [AdminController::class, 'manageCategoryEdit'])->name('manageCategoryEdit');
        Route::post('blog/category/edit/{dataId}', [AdminController::class, 'manageCategoryEditPost'])->name('manageCategoryEditPost');
        Route::get('/blog/category/add-new', [AdminController::class, 'manageCategoryAdd'])->name('manageCategoryAdd');
        Route::post('/blog/category/add-new', [AdminController::class, 'manageCategoryAddPost'])->name('manageCategoryAddPost');
        Route::get('/blog/category/delete/{dataId}', [AdminController::class, 'manageCategoryDelete'])->name('manageCategoryDelete');
        Route::get('/blog/category/delete-multiple', [AdminController::class, 'manageCategoryDeleteMultiple'])->name('manageCategoryDeleteMultiple');

        Route::get('/blog/comments', [AdminController::class, 'manageComment'])->name('manageComment');
        Route::get('/blog/comments/edit/{dataId}', [AdminController::class, 'manageCommentEdit'])->name('manageCommentEdit');
        Route::post('blog/comments/edit/{dataId}', [AdminController::class, 'manageCommentEditPost'])->name('manageCommentEditPost');
        Route::get('/blog/comments/add-new', [AdminController::class, 'manageCommentAdd'])->name('manageCommentAdd');
        Route::post('/blog/comments/add-new', [AdminController::class, 'manageCommentAddPost'])->name('manageCommentAddPost');
        Route::get('/blog/comments/delete/{dataId}', [AdminController::class, 'manageCommentDelete'])->name('manageCommentDelete');
        Route::get('/blog/comments/delete-multiple', [AdminController::class, 'manageCommentDeleteMultiple'])->name('manageCommentDeleteMultiple');

        Route::get('/blog', [AdminController::class, 'manageBlog'])->name('manageBlog');
        Route::get('/blog/edit/{dataId}', [AdminController::class, 'manageBlogEdit'])->name('manageBlogEdit');
        Route::post('blog/edit/{dataId}', [AdminController::class, 'manageBlogEditPost'])->name('manageBlogEditPost');
        Route::get('/blog/add-new', [AdminController::class, 'manageBlogAdd'])->name('manageBlogAdd');
        Route::post('/blog/add-new', [AdminController::class, 'manageBlogAddPost'])->name('manageBlogAddPost');
        Route::get('/blog/delete/{dataId}', [AdminController::class, 'manageBlogDelete'])->name('manageBlogDelete');
        Route::get('/blog/delete-multiple', [AdminController::class, 'manageBlogDeleteMultiple'])->name('manageBlogDeleteMultiple');

        Route::get('/settings', [AdminController::class, 'manageSettings'])->name('manageSettings');
        Route::post('/settings', [AdminController::class, 'manageSettingsPost'])->name('manageSettingsPost');


        Route::group(['prefix' => 'laravel-filemanager'], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

     });

});
