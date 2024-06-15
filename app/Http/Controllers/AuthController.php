<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\UserInformation;
use App\Models\UserInterests;
use App\Helpers\UserRoles;
use App\Helpers\UserGender;
use App\Helpers\ErrorStatus;
use App\Helpers\SuccessStatus;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailUserVerificationMail;
use App\Models\Departments;
use App\Models\Levels;
use App\Models\Schools;
use App\Models\UserVerification;
use App\Models\Interest;
use App\Http\Resources\UserDepartmentResources;
use App\Http\Resources\UserSchoolResources;
use App\Http\Resources\LevelsResources;
use App\Http\Resources\UserInterestResources;
use App\Services\Api\TermiApi;

class AuthController extends Controller
{
    public function verifyUser(Request $request)
    {
        if ($request->type === "phone") {
            return $this->verifyPhoneNumber($request);
        } elseif ($request->type === "email") {
            return $this->verifyEmailAddress($request);
        } else {
            return response()->json([ErrorStatus::ERROR  => [ErrorStatus::REQUEST_INVALID => ['Invalid request, request not understood, phone or email must be set !']]], 422);
        }
    }

    private function generateVerificationCode()
    {
        $key = random_int(0, 999999);
       return str_pad($key, 6, 0, STR_PAD_LEFT);
    }

    private function verifyEmailAddress(Request $request)
    {
        $rules = array(
            'email' => 'required|max:225|min:5|string|email|unique:users,email'
        );
        $messages = [
            'email.required' => '* Your Email is required',
            'email.string' => '* Invalid Characters',
            'email.min' => '* Invalid can not be this short',
            'email.max' => '* Invalid can not be this long',
            'email.email' => '* Must be of Email format with \'@\' symbol',
            'email.unique' => '* Email is already taken by someone else',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::VALIDATION_ERROR => $validator->errors()], 422);
        } else {

            if(UserVerification::where('email', $request->email)->exists()){
                UserVerification::where('email', $request->email)->delete();
            }

            $verificationCode = $this->generateVerificationCode();

            $emailUserVerification = new UserVerification();
            $emailUserVerification->email = $request->email;
            $emailUserVerification->code = $verificationCode;
            $emailUserVerification->save();

            try {
                Mail::to($request->email)->send(new EmailUserVerificationMail($verificationCode));
                return response()->json([SuccessStatus::SUCCESS => 'E-mail verification sent successfully.']);
            } catch (\Exception $ex) {
                return response()->json([ErrorStatus::REQUEST_ERROR => [ErrorStatus::REQUEST_ERROR => ['Sorry, our system is unable to process request at this time, likely unable to send email.']]], 422);
            }
        }
    }

    private function verifyPhoneNumber(Request $request)
    {
        $rules = array(
            'phone' => 'required|string|max:225|min:9|unique:users,email',
        );
        $messages = [

            'phone.required' => '* Phone number is required',
            'phone.string' => '* Invalid Characters',
            'phone.max' => '* Your phone number can not be this long',
            'phone.min' => '* Your phone number can not be this short',
            'unique.unique' => '* Phone is already taken by someone else',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::VALIDATION_ERROR => $validator->errors()], 422);
        } else {

            if(UserVerification::where('phone', $request->phone)->exists()){
                UserVerification::where('phone', $request->phone)->delete();
            }

            $verificationCode = $this->generateVerificationCode();

            $phoneUserVerification = new UserVerification();
            $phoneUserVerification->phone = $request->phone;
            $phoneUserVerification->code = $verificationCode;
            $phoneUserVerification->save();

            try {
                $smsGateway = new TermiApi();
                $smsGateway->sendVerificationSms($request->phone, $verificationCode);
                return response()->json([SuccessStatus::SUCCESS => 'Phone Number verification sent successfully.']);

            } catch (\Exception $ex) {
                return response()->json([ErrorStatus::REQUEST_ERROR => [ErrorStatus::REQUEST_ERROR => ['Sorry, our system is unable to process request at this time, likely unable to send SMS.']]], 422);
            }
        }
    }

    public function verifyOtpCode(Request $request){
        $rules = array(
            'otp_code' => 'required|string|max:6',
            'otp_type' => 'required|string',
            'email' => 'nullable|string|email',
            'phone' => 'nullable|string',
        );
        $messages = [

            'otp_code.required' => '* OTP code is required',
            'otp_code.string' => '* Invalid Characters',
            'otp_code.max' => '* OTP is too long',

            'otp_type.required' => '* OTP type is required',
            'otp_type.string' =>  '* Invalid Characters',

            'email.string' =>  '* Invalid Characters',
            'email.email' => '* Must be of Email format with \'@\' symbol',

            'phone.string' =>  '* Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {

            if($request->otp_type == "phone"){
                $userVerification = UserVerification::where('phone', $request->phone)->first();
                if(!$userVerification){
                    return response()->json([ErrorStatus::ERROR => [ErrorStatus::VALIDATION_ERROR => ['Sorry, Our system could not verify your otp code.']]], 422);
                }
                if($userVerification->code !== $request->otp_code){
                    return response()->json([ErrorStatus::ERROR => [ErrorStatus::VALIDATION_ERROR => ['Sorry, you have entered an invalid OTP code.']]], 422);
                }
            } else {
                $userVerification = UserVerification::where('email', $request->email)->first();
                if(!$userVerification){
                    return response()->json([ErrorStatus::ERROR => [ErrorStatus::VALIDATION_ERROR => ['Sorry, Our system could not verify your otp code.']]], 422);
                }
                if($userVerification->code !== $request->otp_code){
                    return response()->json([ErrorStatus::ERROR => [ErrorStatus::VALIDATION_ERROR => ['Sorry, you have entered an invalid OTP code.']]], 422);
                }
            }

            UserVerification::where('code', $request->otp_code)->delete();
            return response()->json([SuccessStatus::SUCCESS => 'OTP verification successfully.']);
        }
    }

    public function loginViaEmail(Request $request){
        $rules = array(
            'email' => 'required|string|email',
            'type' => 'required|string|max:5',
            'password' => 'required|string',
        );
        $messages = [
            'email.required' => '* Your Email is required',
            'email.string' => '* Invalid Characters',
            'email.email' => '* Must be of Email format with \'@\' symbol',

            'type.required' => '* Login type is required',
            'type.string' => '* Invalid Characters',
            'type.max' => '* Login type must be of type email or phone',

            'password.required' => 'This field is required',
            'password.string' => 'Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {

            $credentials = request(['email', 'password']);

            $token = auth()->attempt($credentials);
            if ($token) {
                return $this->respondWithToken($token);
            } else {
                return response()->json([ErrorStatus::ERROR => [ErrorStatus::AUTHENTICATION_ERROR => ['These credentials do not match our records. ']]], 422);
            }

        }
    }

    public function loginViaPhone(Request $request){

        $rules = array(
            'phone' => 'required|string',
            'type' => 'required|string|max:5',
            'password' => 'required|string',
        );
        $messages = [
            'phone.required' => '* Your Email is required',
            'phone.string' => '* Invalid Characters',
            'phone.email' => '* Must be of Email format with \'@\' symbol',

            'type.required' => '* Login type is required',
            'type.string' => '* Invalid Characters',
            'type.max' => '* Login type must be of type email or phone',

            'password.required'   => 'This field is required',
            'password.string'   => 'Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {
            $credentials = request(['phone', 'password']);

            $token = auth()->attempt($credentials);
            if ($token) {
                return $this->respondWithToken($token);
            } else {
                return response()->json([ErrorStatus::ERROR => [ErrorStatus::AUTHENTICATION_ERROR => ['These credentials do not match our records. ']]], 422);
            }
        }
    }
    public function login(Request $request)
    {
        if($request->type == "email") {
            return $this->loginViaEmail($request);
        } elseif($request->type == "phone") {
            return $this->loginViaPhone($request);
        } else {
            return response()->json([ErrorStatus::ERROR => [ErrorStatus::AUTHENTICATION_ERROR => ['Unrecognised Login Attempt ']]], 422);
        }
    }


    public function register(Request $request)
    {
        $rules = array(
            'name' => 'required|string|max:225|min:2',
            'email' => 'nullable|string|email|unique:users,email',
            'phone' => 'nullable|string|max:225|min:9|unique:users,phone',
            'dob' => 'required|string',
            'gender' => 'required|string|max:225|min:2',
            'password' => 'required|string',
        );
        $messages = [
            'name.required' => '* Name is required',
            'name.string' => '* Invalid Characters',
            'name.max' => '* Your name can not be this long',
            'name.min' => '* Your name can not be this short',

            'email.required' => '* E-mail address is required',
            'email.string' => '* Invalid Characters',
            'email.max' => '* Your E-mail address can not be this long',
            'email.unique' => '* Email is already taken by someone else',

            'phone.string' => '* Invalid Characters',
            'phone.max' => '* Your phone number can not be this long',
            'phone.min' => '* Your phone number can not be this short',

            'password.required'   => 'Password is required',
            'password.string'   => 'Invalid Characters',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([ErrorStatus::ERROR => $validator->errors()], 422);
        } else {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->dob = $request->dob;
            $user->gender = UserGender::tryFrom($request->gender) ?? UserGender::STATE_MALE;
            $user->password = Hash::make($request->password);
            $user->role_id = UserRoles::tryFrom($request->role) ?? UserRoles::STATE_GENERAL_PUBLIC;
            $user->save();

            $userInformation = new UserInformation();
            $userInformation->user_id = $user->id;
            $userInformation->department_id = $request->department_id ?? null;
            $userInformation->school_id = $request->school_id ?? null;
            $userInformation->level_id = $request->level_id ?? null;
            $userInformation->save();

            $userInterest = new UserInterests();
            foreach ($request->user_interest as $item) {
                $userInterest->user_id = $user->id;
                $userInterest->interest_id = $item;
                $userInterest->save();
            }

            if($request->email) {
                $data = auth()->attempt(request(['email', 'password']));
            } else {
                $data = auth()->attempt(request(['phone', 'password']));
            }

            return $this->respondWithToken($data);
        }
    }

    public function getDepartment(){
        $department = Departments::get();
        return response()->json([SuccessStatus::DATA => UserDepartmentResources::collection($department)]);
    }

    public function getSchools(){
        $schools = Schools::get();
        return response()->json([SuccessStatus::DATA => UserSchoolResources::collection($schools)]);
    }

    public function getLevels(){
        $levels = Levels::get();
        return response()->json([SuccessStatus::DATA => LevelsResources::collection($levels)]);
    }

    public function getUserInterests(){
        $userInterest = Interest::get();
        return response()->json([SuccessStatus::DATA => UserInterestResources::collection($userInterest)]);
    }


    public function me()
    {
        return response()->json(auth()->user());
    }


    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'refresh_token' => auth()->refresh(),
                'type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]
        ]);
    }

    public function check()
    {
        if (Auth::check()) {
            return response()->json(['data' => 1]);
        } else {
            return response()->json(['data' => 0]);
        }
    }

    private function respondWithToken($token)
    {
        $user = User::where("id", Auth::user()->id)->first();
        $user->last_login = Carbon::now();
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged In Successfully',
            'data' => [
                'user_id' => $user->id,
                'access_token' => $token,
                'type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'name' => $user->name,
                'email' => isset($user->email) ? $user->email : null,
                'phone' => isset($user->phone) ? $user->phone : null,
                'avatar' => asset("storage/images/users/".$user->avatar),
            ]

        ]);
    }
}
