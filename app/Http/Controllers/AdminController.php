<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Blog;
use App\Models\BlogCategories;
use App\Models\BlogComment;
use App\Models\BlogLikes;
use App\Models\CategoryBlog;
use App\Models\Departments;
use App\Models\GeneralSettings;
use App\Models\Interest;
use App\Models\Levels;
use App\Models\Schools;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\UserInterests;
use App\Models\Product;
use App\Models\ProductTag;
use App\Models\ProductComment;
use App\Models\ProductCommentLike;
use App\Models\Forum;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Roles;
use PhpParser\Comment;
use RealRashid\SweetAlert\Facades\Alert;
use App\Helpers\LaravelFileManagerSorter;
use Illuminate\Support\Facades\Hash;
use App\Rules\UniqueArray;
use Carbon\Carbon;


class AdminController extends Controller
{
    public function adminDashboard(){
    
        $usersToday = User::whereDate('created_at', today())->count();
        $usersActive = User::where('status', 1)->count();
        $usersRestricted = User::where('status', 0)->count();
        
        $regularUsers = User::where('role_id', 4)->count();
        $studentUsers = User::where('role_id', 1)->count();
        $staffUsers = User::where('role_id', 2)->orWhere('role_id', 3)->count();
        $adminUsers = User::where('role_id', 5)->orWhere('role_id', 6)->count();

        $departments = Departments::count();
        $schools = Schools::count();
        $interests = Interest::count();
         
        $allBlogs = Blog::count();
        $activeBlogs = Blog::where('is_featured', 1)->count();
        $pendingBlogs = Blog::where('is_featured', 0)->count();

        $allBlogCategories = BlogCategories::count();
        $activeBlogCategories  = BlogCategories::where('is_featured', 1)->count();
        $pendingBlogCategories  = BlogCategories::where('is_featured', 0)->count();
        $allBlogComments = BlogComment::count();
        $allBlogLikes = BlogLikes::count();

        $allForums = Forum::count();
        $activeForums = Forum::where('is_featured', 1)->count();
        $pendingForums = Forum::where('is_featured', 0)->count();
        $allForumComments = ForumComment::count();

        $allProducts  = Product::where('type', 'product')->count();
        $activeProducts  = Product::where('type', 'product')->where('is_featured', 1)->count();
        $pendingProducts  = Product::where('type', 'product')->where('is_featured', 0)->count();

        $allServices  = Product::where('type', 'service')->count();
        $activeServices  = Product::where('type', 'service')->where('is_featured', 1)->count();
        $pendingServices  = Product::where('type', 'service')->where('is_featured', 0)->count();

        $allTags = ProductTag::count();

        $allProductComments = ProductComment::count();
        $allProductCommentLikes = ProductCommentLike::count();

        return view("pages.admin.dashboard.dashboard", compact(
            'usersToday',
            'usersActive',
            'usersRestricted',
            'regularUsers',
            'studentUsers',
            'staffUsers',
            'adminUsers',
            'departments',
            'schools',
            'interests',
            'allBlogs',
            'activeBlogs',
            'pendingBlogs',
            'allBlogCategories',
            'activeBlogCategories',
            'pendingBlogCategories',
            'allBlogComments',
            'allBlogLikes',
            'allForums',
            'activeForums',
            'pendingForums',
            'allForumComments',
            'allProducts',
            'activeProducts',
            'pendingProducts',
            'allServices',
            'activeServices',
            'pendingServices',
            'allTags',
            'allProductComments',
            'allProductCommentLikes',
        ));
    }

    public function AdminLogout(){
        $user = Auth::guard('web')->user();
        Session::flush();
        Auth::guard('web')->logout($user);
        Alert::toast('Logged Out Successfully', 'success')->autoClose(10000);
        return redirect()->route('adminLogin');
    }

    public function adminLogin()
    {
        return view('pages.auth.login');
    }

    public function adminLoginPost(Request $request)
    {

        $rules = array(
            'email' => 'required|string|email',
            'password' => 'required|string',
        );
        $messages = [
            'email.required' => '* Your Email is required',
            'email.string' => '* Invalid Characters',
            'email.email' => '* Must be of Email format with \'@\' symbol',

            'password.required'   => 'This field is required',
            'password.string'   => 'Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $credentials = $request->only('email', 'password');
            $check = Auth::guard('web')->attempt($credentials);

            if (!$check) {
                Alert::toast('invalid username or Password, please check your credentials and try again.', 'error');
                return redirect()->back();
            }

            $authUser = Auth::guard('web')->user();
            if($authUser->role_id == Roles::DEFAULT_ADMIN_ROLE || $authUser->role_id == Roles::DEFAULT_MODERATOR_ROLE ) {
                return redirect()->route('adminDashboard');
            } else {
                Alert::toast('invalid username or Password, please check your credentials and try again.', 'error');
                return redirect()->back();
            }
        }
    }

    /////users/////
    public function manageUser(){
        $data = User::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.user.all", compact('data'));
    }

    public function manageUserAdd(){
        $roles = [
            '1'=>'Moderator',
            '2'=>'Administrator',
            '3'=>'General Public',
            '4'=>'School Staff',
            '5'=>'Lecturer',
            '6'=>'Student',
        ];
        $schools = Schools::all();
        $departments = Departments::all();
        $levels = Levels::all();
        $interests = Interest::all();
        return view("pages.admin.user.add", compact('roles', 'schools', 'departments', 'levels', 'interests'));
    }

    public function manageUserAddPost(Request $request){
        $rules = array(
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'status' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'role' => 'required',
            'avatar' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',
            'school' => 'required',
            'department' => 'required',
            'level' => 'required',
            'interests' => 'required|array|min:1',
            //'interests.*' => 'exists:interests,id',

        );
        $messages = [
            'fullname.required' => '* Fullname is required',
            'fullname.string' => '* Invalid Characters',
            'fullname.max' => '* Fullname is too long',

            'email.required' => '* Email is required',
            'email.email' => '* Email must be a format with \'@\' symbol',
            'email.unique' => '* Email already exists',

            'phone.required' => '* Phone Number is required',

            'status.required' => '* Status is required',

            'dob.required' => '* Date of birth is required',

            'gender.required' => '* Gender is required',

            'role.required' => '* Role is required',

            'avatar.mimnes' => '* Image allowed formats are jpg, png, jpeg, webp',

            'school.required' => '* School is required',
            'department.required' => '* Department is required',
            'level.required' => '* Level is required',
            'interests.required' => '* At least one interest is required',
            'interests.array' => '* Invalid format for interests',
            'interests.min' => '* At least one interest is required',
            //'interests.*.exists' => '* Invalid interest selected',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new User();
            $data->name = $request->fullname;
            $data->email = $request->email;
            $data->password = Hash::make('password');
            $data->phone = $request->phone;
            $data->status = $request->status;
            $data->dob = $request->dob;
            $data->gender = $request->gender;
            $data->role_id = (int) $request->role;

            if ($request->has('avatar')) {
                $image_name = Helpers::upload('images/users/', 'png', $request->file('avatar'));
                $data->avatar = $image_name;
            }
            $data->save();

            $data->interests()->sync($request->interests);

            $userInformation = new UserInformation();
            $userInformation->user_id = $data->id;
            $userInformation->school_id = !empty($request->school) ? $request->school : null;
            $userInformation->department_id = !empty($request->department) ? $request->department : null;
            $userInformation->level_id = !empty($request->level) ? $request->level : null;;
            $userInformation->save();

            Alert::toast('User Added Successfully', 'success')->autoClose(10000);
            return redirect()->route('manageUser');
        }
    }

    public function manageUserEdit($dataId){

        $data = User::where("id", $dataId)->firstOrFail();
        $roles = [
            '1'=>'Moderator',
            '2'=>'Administrator',
            '3'=>'General Public',
            '4'=>'School Staff',
            '5'=>'Lecturer',
            '6'=>'Student',
        ];
        $schools = Schools::all();
        $departments = Departments::all();
        $levels = Levels::all();
        $interests = Interest::all();

        $userInterestIds = $data->interests()->pluck('interests.id')->toArray();
        $userSchool = $data->schools()->latest()->first();
        $userDepartment = $data->departments()->latest()->first();
        $userLevel = $data->levels()->latest()->first();

        return view("pages.admin.user.edit", compact('data','roles', 'schools', 'departments', 'levels', 'interests', 'userInterestIds', 'userSchool', 'userDepartment', 'userLevel'));
    }
    public function manageUserEditPost(Request $request, $dataId){
        $rules = array(
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable',
            'status' => 'required',
            'dob' => 'nullable',
            'gender' => 'required',
            'role' => 'required',
            'avatar' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',
            'school' => 'nullable',
            'department' => 'nullable',
            'level' => 'nullable',
            'interests' => 'nullable|array|min:1',
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',

            'email.required' => '* Email is required',
            'email.email' => '* Email must be a format with \'@\' symbol',

            'status.required' => '* Status is required',

            'dob.required' => '* Date of birth is required',

            'gender.required' => '* Gender is required',

            'role.required' => '* Role is required',

            'avatar.mimnes' => '* Image allowed formats are jpg, png, jpeg, webp',

            'school.required' => '* School is required',
            'department.required' => '* Department is required',
            'level.required' => '* Level is required',
            'interests.required' => '* At least one interest is required',
            'interests.array' => '* Invalid format for interests',
            'interests.min' => '* At least one interest is required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = User::where("id", $dataId)->firstOrFail();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = Hash::make('password');
            $data->phone = $request->phone;
            $data->status = $request->status;
            $data->dob = $request->dob;
            $data->gender = $request->gender;
            $data->role_id = (int) $request->role;

            if ($request->has('avatar')) {
                $image_name = Helpers::upload('images/users/', 'png', $request->file('avatar'));
                $data->avatar = $image_name;
            }
            $data->save();

            $data->interests()->sync($request->interests);

            $userInformation = UserInformation::where('user_id',$data->id)->latest()->first();
            $userInformation->school_id = !empty($request->school) ? $request->school : null;
            $userInformation->department_id = !empty($request->department) ? $request->department : null;
            $userInformation->level_id = !empty($request->level) ? $request->level : null;;
            $userInformation->save();

            Alert::toast('User Updated Successfully', 'success')->autoClose(10000);
            return redirect()->back();
        }
    }
    //single & bulk-delete
    public function manageUserDelete($id){
        $data = User::findOrFail($id);
        UserInformation::where('user_id',$data->id)->delete();
        UserInterests::where('user_id',$data->id)->delete();
        $data->delete();
        Alert::toast('User Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageUser');
    }
    public function manageUserDeleteMultiple(Request $request){
        UserInformation::whereIn('user_id',explode(",", $request->selectItemId))->delete();
        UserInterests::whereIn('user_id',explode(",", $request->selectItemId))->delete();
        User::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Users Removed Successfully"]);
    }

    //listing - products & services
    public function manageListing(){
        $data = Product::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.listing.all", compact('data'));
    }
    public function manageListingAdd(){
        $productTags = ProductTag::all();
        return view("pages.admin.listing.add", compact('productTags'));
    }
    public function manageListingAddPost(Request $request){
        $rules = array(
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'type' => 'required',
            'amount' => 'required|numeric',
            'tag_id' => 'required',
            'location' => 'required|string|max:255',
            'phone' => 'required',
            'whatsapp' => 'required',
            'is_featured' => 'required',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',
        );
        $messages = [
            'title.required' => '* Title is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Title is too long',

            'description.required' => '* Description is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Description is too long',

            'type.required' => '* Type Number is required',

            'tag_id.required' => '* Listing-Tag is required',

            'location.required' => '* Location is required',
            'location.string' => '* Invalid Characters',
            'location.max' => '* Location is too long',

            'phone.required' => '* Phone is required',
            'phone.numeric' => '* Phone must be a number',

            'whatsapp.required' => '* Whatsapp is required',
            'whatsapp.numeric' => '* Whatsapp must be a number',

            'featured_image.mimnes' => '* Image allowed formats are jpg, png, jpeg, webp',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new Product();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->type = $request->type;
            $data->created_by_id = auth()->user()->id;;
            $data->amount = $request->amount;
            $data->product_tag_id = $request->tag_id;
            $data->location = $request->location;
            $data->phone = $request->phone;
            $data->whatsapp = $request->whatsapp;
            $data->is_featured = (int) $request->is_featured;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('product/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Listing Added Successfully', 'success')->autoClose(10000);
            return redirect()->route('manageListing');
        }
    }
    public function manageListingEdit($dataId){
        $data = Product::where("id", $dataId)->firstOrFail();
        $productTags = ProductTag::all();
        $selectedProductTag = $data->tag;

        return view("pages.admin.listing.edit", compact('data','productTags','selectedProductTag'));
    }
    public function manageListingEditPost(Request $request, $dataId){
        $rules = array(
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'type' => 'required',
            'amount' => 'required|numeric',
            'tag_id' => 'required',
            'location' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'whatsapp' => 'required|numeric',
            'is_featured' => 'required',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',
        );
        $messages = [
            'title.required' => '* Title is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Title is too long',

            'description.required' => '* Description is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Description is too long',

            'type.required' => '* Type Number is required',

            'tag_id.required' => '* Listing-Tag is required',

            'location.required' => '* Location is required',
            'location.string' => '* Invalid Characters',
            'location.max' => '* Location is too long',

            'phone.required' => '* Phone is required',
            'phone.numeric' => '* Phone must be a number',

            'whatsapp.required' => '* Whatsapp is required',
            'whatsapp.numeric' => '* Whatsapp must be a number',

            'featured_image.mimnes' => '* Image allowed formats are jpg, png, jpeg, webp',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = Product::where("id", $dataId)->firstOrFail();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->type = $request->type;
            $data->created_by_id = auth()->user()->id;;
            $data->amount = $request->amount;
            $data->product_tag_id = $request->tag_id;
            $data->location = $request->location;
            $data->phone = $request->phone;
            $data->whatsapp = $request->whatsapp;
            $data->is_featured = (int) $request->is_featured;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('product/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Listing Updated Successfully', 'success')->autoClose(10000);
            return back();
        }
    }
    public function manageListingDelete($id){
        $data = Product::findOrFail($id);
        $data->delete();
        Alert::toast('Listing Removed Successfully', 'success')->autoClose(3000);
        return redirect()->route('manageListing');
    }
    public function manageListingDeleteMultiple(Request $request){
        Product::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Listings Removed Successfully"]);
    }


    //Lisiting tags
    public function manageListingTag(){
        $data = ProductTag::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.listing.tags.all", compact('data'));
    }
    public function manageListingTagAdd(){
        return view("pages.admin.listing.tags.add");
    }
    public function manageListingTagDelete($id){
        $data = ProductTag::findOrFail($id);
        $data->delete();
        Alert::toast('Item Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageListingTag');
    }
    public function manageListingTagDeleteMultiple(Request $request){
        ProductTag::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Item Removed Successfully"]);
    }
    public function manageListingTagAddPost(Request $request){

        $rules = array(
            'title' => 'required|string|max:255|unique:levels,name'
        );
        $messages = [
            'title.required' => '* Item name is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new ProductTag();
            $data->title = $request->title;
            $data->save();

            Alert::toast('Listing tag Created Successfully', 'success')->autoClose(3000);
            return redirect()->route('manageListingTag');
        }
    }
    public function manageListingTagEdit($dataId){
        $data = ProductTag::where("id", $dataId)->firstOrFail();
        return view("pages.admin.listing.tags.edit", compact('data'));
    }
    public function manageListingTagEditPost(Request $request, $dataId){

        $rules = array(
            'title' => 'required|string|max:255|unique:levels,name,' . $dataId . ',id'
        );
        $messages = [
            'title.required' => '* Item name is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = ProductTag::where("id", $dataId)->firstOrFail();
            $data->title = $request->title;
            $data->save();

            Alert::toast('Listing tag Updated Successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }



    //forum
    public function manageForum(){
        $data = Forum::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.forum.all", compact('data'));
    }
    public function manageForumAdd(){
        return view("pages.admin.forum.add");
    }
    public function manageForumAddPost(Request $request){
        $rules = array(
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_featured' => 'required',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',
        );
        $messages = [
            'title.required' => '* Title is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Title is too long',

            'description.required' => '* Description is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Description is too long',

            'is_featured.required' => '* Status is required',

            'featured_image.mimnes' => '* Image allowed formats are jpg, png, jpeg, webp',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new Forum();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->created_by_id = auth()->user()->id;;
            $data->is_featured = (int) $request->is_featured;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('forum/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Forum Added Successfully', 'success')->autoClose(10000);
            return redirect()->route('manageForum');
        }
    }
    public function manageForumEdit($dataId){
        $data = Forum::where("id", $dataId)->firstOrFail();
        return view("pages.admin.forum.edit", compact('data'));
    }
    public function manageForumEditPost(Request $request, $dataId){
        $rules = array(
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_featured' => 'required',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',
        );
        $messages = [
            'title.required' => '* Title is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Title is too long',

            'description.required' => '* Description is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Description is too long',

            'is_featured.required' => '* Status is required',

            'featured_image.mimnes' => '* Image allowed formats are jpg, png, jpeg, webp',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = Forum::where("id", $dataId)->firstOrFail();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->created_by_id = auth()->user()->id;;
            $data->is_featured = (int) $request->is_featured;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('forum/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Forum Updated Successfully', 'success')->autoClose(10000);
            return redirect()->route('manageForum');
        }
    }
    public function manageForumDelete($id){
        $data = Forum::findOrFail($id);
        $data->comments()->delete();
        $data->delete();
        Alert::toast('Forum Removed Successfully', 'success')->autoClose(3000);
        return redirect()->route('manageForum');
    }
    public function manageForumDeleteMultiple(Request $request){
        ForumComment::whereIn('forum_id', explode(",", $request->selectItemId))->delete();
        Forum::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Forums Removed Successfully"]);
    }

    //forum comments
    public function manageForumComment(){
        $data = ForumComment::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.forum.comment.all", compact('data'));
    }
    public function manageForumCommentAdd(){
        $forums = Forum::all();
        return view("pages.admin.forum.comment.add", compact('forums'));
    }
    public function manageForumCommentAddPost(Request $request){
        $rules = array(
            'forum_id' => 'required',
            'message' => 'required|string|max:255',
            'uploaded_file' => 'nullable|max:10025',
        );
        $messages = [
            'forum_id.required' => '* Forum is required',

            'message.required' => '* Description is required',
            'message.string' => '* Invalid Characters',
            'message.max' => '* Description is too long',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new ForumComment();
            $data->forum_id = $request->forum_id;
            $data->message = $request->message;
            $data->created_by_id = auth()->user()->id;;

            if ($request->has('uploaded_file')) {
                $image_name = Helpers::upload('forum/comment/', 'png', $request->file('uploaded_file'));
                $data->file = $image_name;
                $data->file_type = 'image';
            }
            $data->save();

            Alert::toast('Comment Added Successfully', 'success')->autoClose(10000);
            return redirect()->route('manageForumComment');
        }
    }
    public function manageForumCommentEdit($dataId){
        $data = ForumComment::findOrFail($dataId);
        $selectedForum = $data->forum;
        $forums = Forum::all();
        return view("pages.admin.forum.comment.edit", compact('data','selectedForum','forums'));
    }
    public function manageForumCommentEditPost(Request $request, $dataId){
        $rules = array(
            'forum_id' => 'required',
            'message' => 'required|string|max:255',
            'uploaded_file' => 'nullable|max:10025',
        );
        $messages = [
            'forum_id.required' => '* Forum is required',

            'message.required' => '* Description is required',
            'message.string' => '* Invalid Characters',
            'message.max' => '* Description is too long',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = ForumComment::findOrFail($dataId);
            $data->forum_id = $request->forum_id;
            $data->message = $request->message;
            $data->created_by_id = auth()->user()->id;;

            if ($request->has('uploaded_file')) {
                $image_name = Helpers::upload('forum/comment/', 'png', $request->file('uploaded_file'));
                $data->file = $image_name;
                $data->file_type = 'image';
            }
            $data->save();

            Alert::toast('Comment Updated Successfully', 'success')->autoClose(10000);
            return back();
        }
    }
    public function manageForumCommentDelete($id){
        $data = ForumComment::findOrFail($id);
        $data->delete();
        Alert::toast('Forum Comment Removed Successfully', 'success')->autoClose(3000);
        return back();
    }
    public function manageForumCommentDeleteMultiple(Request $request){
        ForumComment::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Comments Removed Successfully"]);
    }

    //////////

    public function manageDepartment(){
        $data = Departments::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.data-sets.department.all", compact('data'));
    }
    public function manageDepartmentAdd(){
        return view("pages.admin.data-sets.department.add");
    }
    public function manageDepartmentDelete($id){
        $data = Departments::findOrFail($id);
        $data->delete();
        Alert::toast('Item Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageDepartment');
    }
    public function manageDepartmentDeleteMultiple(Request $request){
        Departments::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Item Removed Successfully"]);
    }
    public function manageDepartmentAddPost(Request $request){

        $rules = array(
            'name' => 'required|string|max:255|unique:departments,name'
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $requests = $request->except('rates.0');
        $validator = Validator::make($requests, $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new Departments();
            $data->name = $request->name;
            $data->save();

            Alert::toast('Department Created Successfully', 'success')->autoClose(3000);
            return redirect()->route('manageDepartment');
        }
    }
    public function manageDepartmentEdit($dataId){
        $data = Departments::where("id", $dataId)->firstOrFail();
        return view("pages.admin.data-sets.department.edit", compact('data'));
    }
    public function manageDepartmentEditPost(Request $request, $dataId){

        $rules = array(
            'name' => 'required|string|max:255|unique:departments,name,' . $dataId . ',id'
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = Departments::where("id", $dataId)->firstOrFail();
            $data->name = $request->name;
            $data->save();

            Alert::toast('Department Updated Successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }


    public function manageLevels(){
        $data = Levels::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.data-sets.levels.all", compact('data'));
    }
    public function manageLevelsAdd(){
        return view("pages.admin.data-sets.levels.add");
    }
    public function manageLevelsDelete($id){
        $data = Levels::findOrFail($id);
        $data->delete();
        Alert::toast('Item Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageLevels');
    }
    public function manageLevelsDeleteMultiple(Request $request){
        Levels::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Item Removed Successfully"]);
    }
    public function manageLevelsAddPost(Request $request){

        $rules = array(
            'name' => 'required|string|max:255|unique:levels,name'
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new Levels();
            $data->name = $request->name;
            $data->save();

            Alert::toast('Level Created Successfully', 'success')->autoClose(3000);
            return redirect()->route('manageLevels');
        }
    }
    public function manageLevelsEdit($dataId){
        $data = Levels::where("id", $dataId)->firstOrFail();
        return view("pages.admin.data-sets.levels.edit", compact('data'));
    }
    public function manageLevelsEditPost(Request $request, $dataId){

        $rules = array(
            'name' => 'required|string|max:255|unique:levels,name,' . $dataId . ',id'
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = Levels::where("id", $dataId)->firstOrFail();
            $data->name = $request->name;
            $data->save();

            Alert::toast('Level Updated Successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }



    public function manageInterest(){
        $data = Interest::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.data-sets.interest.all", compact('data'));
    }
    public function manageInterestAdd(){
        return view("pages.admin.data-sets.interest.add");
    }
    public function manageInterestDelete($id){
        $data = Interest::findOrFail($id);
        $data->delete();
        Alert::toast('Item Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageInterest');
    }
    public function manageInterestDeleteMultiple(Request $request){
        Interest::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Item Removed Successfully"]);
    }
    public function manageInterestAddPost(Request $request){

        $rules = array(
            'name' => 'required|string|max:255|unique:levels,name'
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new Interest();
            $data->name = $request->name;
            $data->save();

            Alert::toast('Interest Created Successfully', 'success')->autoClose(3000);
            return redirect()->route('manageInterest');
        }
    }
    public function manageInterestEdit($dataId){
        $data = Interest::where("id", $dataId)->firstOrFail();
        return view("pages.admin.data-sets.interest.edit", compact('data'));
    }
    public function manageInterestEditPost(Request $request, $dataId){

        $rules = array(
            'name' => 'required|string|max:255|unique:levels,name,' . $dataId . ',id'
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = Interest::where("id", $dataId)->firstOrFail();
            $data->name = $request->name;
            $data->save();

            Alert::toast('Interest Updated Successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }



    public function manageSchool(){
        $data = Schools::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.data-sets.school.all", compact('data'));
    }
    public function manageSchoolAdd(){
        return view("pages.admin.data-sets.school.add");
    }
    public function manageSchoolDelete($id){
        $data = Schools::findOrFail($id);
        $data->delete();
        Alert::toast('Item Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageSchool');
    }
    public function manageSchoolDeleteMultiple(Request $request){
        Schools::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Item Removed Successfully"]);
    }
    public function manageSchoolAddPost(Request $request){

        $rules = array(
            'name' => 'required|string|max:255|unique:levels,name'
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new Schools();
            $data->name = $request->name;
            $data->save();

            Alert::toast('School Created Successfully', 'success')->autoClose(3000);
            return redirect()->route('manageSchool');
        }
    }
    public function manageSchoolEdit($dataId){
        $data = Schools::where("id", $dataId)->firstOrFail();
        return view("pages.admin.data-sets.school.edit", compact('data'));
    }
    public function manageSchoolEditPost(Request $request, $dataId){

        $rules = array(
            'name' => 'required|string|max:255|unique:levels,name,' . $dataId . ',id'
        );
        $messages = [
            'name.required' => '* Item name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Item name is too long',
            'unique.max' => '* Item with same name already exists',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = Schools::where("id", $dataId)->firstOrFail();
            $data->name = $request->name;
            $data->save();

            Alert::toast('School Updated Successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }


    public function manageCategory(){
        $data = BlogCategories::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.blog.category.all", compact('data'));
    }
    public function manageCategoryAdd(){
        return view("pages.admin.blog.category.add");
    }
    public function manageCategoryDelete($id){
        $data = BlogCategories::findOrFail($id);
        $data->delete();
        Alert::toast('Item Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageCategory');
    }
    public function manageCategoryDeleteMultiple(Request $request){
        BlogCategories::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Item Removed Successfully"]);
    }
    public function manageCategoryAddPost(Request $request){

        $rules = array(
            'title' => 'required|string|max:255|unique:blog_categories,title',
            'description' => 'required|string|max:3000|max:10025',
            'is_featured' => 'nullable|string',
            'featured_image' => 'required|mimes:jpg,png,jpeg,webp',

        );
        $messages = [
            'title.required' => '* Item name is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Item name is too long',
            'title.unique' => '* Item with same name already exists',

            'description.required' => '* Item name is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Item name is too long',

            'is_featured.required' => '* Is Featured field is required',
            'is_featured.string' => '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new BlogCategories();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->is_featured = $request->is_featured;
            $data->created_by_id = auth()->user()->id;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('blog-category/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Category Created Successfully', 'success')->autoClose(3000);
            return redirect()->route('manageCategoryEdit', $data->id);
        }
    }
    public function manageCategoryEdit($dataId){
        $data = BlogCategories::where("id", $dataId)->firstOrFail();
        return view("pages.admin.blog.category.edit", compact('data'));
    }
    public function manageCategoryEditPost(Request $request, $dataId){

        $rules = array(
            'title' => 'required|string|max:255|unique:blog_categories,title,' . $dataId . ',id',
            'description' => 'required|string|max:3000',
            'is_featured' => 'nullable|string',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',

        );
        $messages = [
            'title.required' => '* Item name is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Item name is too long',
            'title.unique' => '* Item with same name already exists',

            'description.required' => '* Item name is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Item name is too long',

            'is_featured.required' => '* Is Featured field is required',
            'is_featured.string' => '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = BlogCategories::where("id", $dataId)->firstOrFail();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->is_featured = $request->is_featured;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('blog-category/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Category Updated Successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }



    public function manageComment(){
        $data = BlogComment::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.blog.comments.all", compact('data'));
    }
    public function manageCommentAdd(){
        return view("pages.admin.blog.comments.add");
    }
    public function manageCommentDelete($id){
        $data = BlogComment::findOrFail($id);
        $data->delete();
        Alert::toast('Item Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageComment');
    }
    public function manageCommentDeleteMultiple(Request $request){
        BlogComment::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Item Removed Successfully"]);
    }
    public function manageCommentAddPost(Request $request){

        $rules = array(
            'title' => 'required|string|max:255|unique:blog_categories,title',
            'description' => 'required|string|max:3000|max:10025',
            'is_featured' => 'nullable|string',
            'featured_image' => 'required|mimes:jpg,png,jpeg,webp',

        );
        $messages = [
            'title.required' => '* Item name is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Item name is too long',
            'title.unique' => '* Item with same name already exists',

            'description.required' => '* Item name is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Item name is too long',

            'is_featured.required' => '* Is Featured field is required',
            'is_featured.string' => '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new BlogComment();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->is_featured = $request->is_featured;
            $data->created_by_id = auth()->user()->id;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('blog-category/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Category Created Successfully', 'success')->autoClose(3000);
            return redirect()->route('manageCommentEdit', $data->id);
        }
    }
    public function manageCommentEdit($dataId){
        $data = BlogComment::where("id", $dataId)->firstOrFail();
        return view("pages.admin.blog.comments.edit", compact('data'));
    }
    public function manageCommentEditPost(Request $request, $dataId){

        $rules = array(
            'title' => 'required|string|max:255|unique:blog_categories,title,' . $dataId . ',id',
            'description' => 'required|string|max:3000',
            'is_featured' => 'nullable|string',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',

        );
        $messages = [
            'title.required' => '* Item name is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Item name is too long',
            'title.unique' => '* Item with same name already exists',

            'description.required' => '* Item name is required',
            'description.string' => '* Invalid Characters',
            'description.max' => '* Item name is too long',

            'is_featured.required' => '* Is Featured field is required',
            'is_featured.string' => '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = BlogComment::where("id", $dataId)->firstOrFail();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->is_featured = $request->is_featured;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('blog-category/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Category Updated Successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }


    public function manageBlog(){
        $data = Blog::orderBy('created_at', 'desc')->paginate(20);
        return view("pages.admin.blog.post.all", compact('data'));
    }
    public function manageBlogAdd(){
        $users = User::get();
        $categories = BlogCategories::get();
        return view("pages.admin.blog.post.add", compact('categories', 'users'));
    }
    public function manageBlogDelete($id){
        $data = Blog::findOrFail($id);
        $data->delete();
        Alert::toast('Item Removed Successfully', 'success')->autoClose(3000);

        return redirect()->route('manageBlog');
    }
    public function manageBlogDeleteMultiple(Request $request){
        Blog::whereIn('id', explode(",", $request->selectItemId))->delete();
        return response()->json(['success' => "Selected Item Removed Successfully"]);
    }
    public function manageBlogAddPost(Request $request){

        $rules = array(
            'title' => 'required|string|max:255|unique:blog_categories,title',
            'body' => 'nullable|string',
            'is_featured' => 'nullable|string',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',
            'author' => 'required|string'

        );
        $messages = [
            'title.required' => '* Item name is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Item name is too long',
            'title.unique' => '* Item with same name already exists',

            'body.required' => '* Content is required',
            'body.string' => '* Invalid Characters',

            'is_featured.required' => '* Is Featured field is required',
            'is_featured.string' => '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = new Blog();
            $data->title = $request->title;
            $data->body = $request->body;
            $data->is_featured = $request->is_featured;
            $data->created_by_id = $request->author;

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('blog/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();
            $data->categories()->sync($request->categories);

            Alert::toast('Blog Post Updated Successfully', 'success')->autoClose(3000);
            return redirect()->route('manageBlogEditPost', $data->id);
        }
    }
    public function manageBlogEdit($dataId){


        $users = User::get();
        $data = Blog::where("id", $dataId)->firstOrFail();
        $selectedCategories = CategoryBlog::where('blog_id', $dataId)->pluck('category_id')->toArray();
        $categories = BlogCategories::get();
        return view("pages.admin.blog.post.edit", compact('data', 'selectedCategories', 'categories', 'users'));
    }
    public function manageBlogEditPost(Request $request, $dataId){
        $rules = array(
            'title' => 'required|string|max:255|unique:blog_categories,title,' . $dataId . ',id',
            'body' => 'nullable|string',
            'is_featured' => 'nullable|string',
            'featured_image' => 'nullable|mimes:jpg,png,jpeg,webp|max:10025',
            'author' => 'required|string'

        );
        $messages = [
            'title.required' => '* Item name is required',
            'title.string' => '* Invalid Characters',
            'title.max' => '* Item name is too long',
            'title.unique' => '* Item with same name already exists',

            'body.required' => '* Content is required',
            'body.string' => '* Invalid Characters',

            'is_featured.required' => '* Is Featured field is required',
            'is_featured.string' => '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = Blog::where("id", $dataId)->firstOrFail();
            $data->title = $request->title;
            $data->body = $request->body;
            $data->is_featured = $request->is_featured;
            $data->created_by_id = $request->author;
            $data->categories()->sync($request->categories);

            if ($request->has('featured_image')) {
                $image_name = Helpers::upload('blog/', 'png', $request->file('featured_image'));
                $data->featured_image = $image_name;
            }
            $data->save();

            Alert::toast('Blog Post Updated Successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }

    public function manageSettings(){
        $data = GeneralSettings::first();
        return view("pages.admin.settings.manage", compact( 'data'));
    }

    public function manageSettingsPost(Request $request){
        $rules = array(
            'from_name' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'sms_from_name' => 'required|string|max:255',
            'sms_api_key' => 'required|string|max:255',

            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|string|max:255',
            'smtp_username' => 'required|string|max:255',
            'smtp_password' => 'required|string|max:255',
            'smtp_encryption' => 'required|string|max:255',
        );
        $messages = [
            'from_name.required' => '* Fields is required',
            'from_name.string' => '* Invalid Characters',
            'from_name.max' => '* Fields is too long',

            'from_email.required' => '* Fields is required',
            'from_email.string' => '* Invalid Characters',
            'from_email.max' => '* Fields is too long',

            'sms_from_name.required' => '* Fields is required',
            'sms_from_name.string' => '* Invalid Characters',
            'sms_from_name.max' => '* Fields is too long',

            'sms_api_key.required' => '* Fields is required',
            'sms_api_key.string' => '* Invalid Characters',
            'sms_api_key.max' => '* Fields is too long',


            'smtp_host.required' => '* Fields is required',
            'smtp_host.string' => '* Invalid Characters',
            'smtp_host.max' => '* Fields is too long',

            'smtp_port.required' => '* Fields is required',
            'smtp_port.string' => '* Invalid Characters',
            'smtp_port.max' => '* Fields is too long',

            'smtp_username.required' => '* Fields is required',
            'smtp_username.string' => '* Invalid Characters',
            'smtp_username.max' => '* Fields is too long',

            'smtp_password.required' => '* Fields is required',
            'smtp_password.string' => '* Invalid Characters',
            'smtp_password.max' => '* Fields is too long',

            'smtp_encryption.required' => '* Fields is required',
            'smtp_encryption.string' => '* Invalid Characters',
            'smtp_encryption.max' => '* Fields is too long',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {

            $data = GeneralSettings::first();
            $data->from_name =  $request->from_name;
            $data->from_email =  $request->from_email;
            $data->sms_from_name =  $request->sms_from_name;
            $data->sms_api_key =  $request->sms_api_key;

            $data->smtp_host =  $request->smtp_host;
            $data->smtp_port =  $request->smtp_port;
            $data->smtp_username =  $request->smtp_username;
            $data->smtp_password =  $request->smtp_password;
            $data->smtp_encryption =  $request->smtp_encryption;
            $data->save();

            Alert::toast('Settings updated successfully', 'success')->autoClose(3000);
            return redirect()->back();
        }
    }

}
