<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ErrorStatus;
use App\Helpers\SuccessStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class ChangePasswordController extends Controller
{

    public function changePassword(Request $request){
        $rules = [
            'old_password' => 'required|max:120|string',
            'new_password' => 'required|max:120|min:6|string',
            'new_password_confirmation' => 'required|max:120|min:6|string|same:new_password',
        ];

        $messages = [
            'old_password.required' => 'This field is required',
            'old_password.max' => 'This password is too long or invalid',
            'old_password.string' => 'Please enter a valid input',

            'new_password.required' => 'This field is required',
            'new_password.max' => 'Password is too long, please pick something you would remember',
            'new_password.min' => 'Password must be grater than 6 characters',

            'new_password_confirmation.required' => 'This field is required',
            'new_password_confirmation.max' => 'Password is too long, please pick something you would remember',
            'new_password_confirmation.min' => 'Password must be 6 characters long',
            'new_password_confirmation.same' => 'Password confirmation does not match',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }  else {
            if(Hash::check($request->old_password, Auth::user()->password)){

                $user = User::where("id", auth()->user()->id)->first();
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json([SuccessStatus::SUCCESS => "Password updated successfully"]);
            } else {
                return response()->json([ErrorStatus::ERROR  => [ErrorStatus::REQUEST_INVALID => ['Old password is incorrect']]], 422);
            }
        }
    }
}
