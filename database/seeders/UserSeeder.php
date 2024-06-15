<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\UserInterests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Test Admin';
        $user->email = 'testadmin@solveit.com';
        $user->phone = '022225009';
        $user->status = '1';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('admin');
        $user->role_id = 5;
        $user->save();

        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();

        $userInterest = new UserInterests();
        $userInterest->user_id = $user->id;
        $userInterest->interest_id = 1;
        $userInterest->save();

        unset($user);
        unset($userInformation);
        unset($userInterest);


        $user = new User();
        $user->name = 'Test Student';
        $user->email = 'student@solveit.com';
        $user->phone = '0123456789';
        $user->status = '1';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('student');
        $user->role_id = 1;
        $user->save();

        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();

        $userInterest = new UserInterests();
        $userInterest->user_id = $user->id;
        $userInterest->interest_id = 1;
        $userInterest->save();

        unset($user);
        unset($userInformation);
        unset($userInterest);


        $user = new User();
        $user->name = 'Test Lecturer';
        $user->email = 'lecturer@solveit.com';
        $user->phone = '0213456789';
        $user->status = '1';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('lecturer');
        $user->role_id = 1;
        $user->save();


        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();

        $userInterest = new UserInterests();
        $userInterest->user_id = $user->id;
        $userInterest->interest_id = 1;
        $userInterest->save();

        unset($user);
        unset($userInformation);
        unset($userInterest);


        $user = new User();
        $user->name = 'Test School Staff';
        $user->email = 'schoolstaff@solveit.com';
        $user->phone = '0223456709';
        $user->status = '1';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('schoolstaff');
        $user->role_id = 1;
        $user->save();

        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();

        $userInterest = new UserInterests();
        $userInterest->user_id = $user->id;
        $userInterest->interest_id = 1;
        $userInterest->save();

        unset($user);
        unset($userInformation);
        unset($userInterest);


        $user = new User();
        $user->name = 'Test School Staff';
        $user->email = 'testschoolstaff@solveit.com';
        $user->phone = '0223456789';
        $user->status = '1';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('schoolstaff');
        $user->role_id = 1;
        $user->save();

        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();

        $userInterest = new UserInterests();
        $userInterest->user_id = $user->id;
        $userInterest->interest_id = 1;
        $userInterest->save();

        unset($user);
        unset($userInformation);
        unset($userInterest);


        $user = new User();
        $user->name = 'Test General Public';
        $user->email = 'generalpublic@solveit.com';
        $user->phone = '0222456789';
        $user->status = '1';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('generalpublic');
        $user->role_id = 1;
        $user->save();

        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();

        for($i = 1; $i < 8; $i++) {
            $userInterest = new UserInterests();
            $userInterest->user_id = $user->id;
            $userInterest->interest_id = $i;
            $userInterest->save();
        }


        unset($user);
        unset($userInformation);
        unset($userInterest);


        $user = new User();
        $user->name = 'Test Moderator';
        $user->email = 'admin@solveit.com';
        $user->phone = '0222226789';
        $user->status = '1';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('moderator');
        $user->role_id = 1;
        $user->save();

        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();


        $userInterest = new UserInterests();
        $userInterest->user_id = $user->id;
        $userInterest->interest_id = 1;
        $userInterest->save();

        unset($user);
        unset($userInformation);
        unset($userInterest);

        $user = new User();
        $user->name = 'Test Moderator inactive';
        $user->email = 'inactiveadmin@solveit.com';
        $user->phone = '0222222789';
        $user->status = '0';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('moderator');
        $user->role_id = 1;
        $user->save();

        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();

        $userInterest = new UserInterests();
        $userInterest->user_id = $user->id;
        $userInterest->interest_id = 1;
        $userInterest->save();

        unset($user);
        unset($userInformation);
        unset($userInterest);

        $user = new User();
        $user->name = 'Test Admin inactive';
        $user->email = 'inaciveadmin@solveit.com';
        $user->phone = '0222222289';
        $user->status = '0';
        $user->dob = "12/24/1992";
        $user->gender = "male";
        $user->password = Hash::make('admin');
        $user->role_id = 1;
        $user->save();

        $userInformation = new UserInformation();
        $userInformation->user_id = $user->id;
        $userInformation->save();

        $userInterest = new UserInterests();
        $userInterest->user_id = $user->id;
        $userInterest->interest_id = 1;
        $userInterest->save();

        unset($user);
        unset($userInformation);
        unset($userInterest);


        for($i = 0; $i < 25; $i++){
            $faker = Factory::create();

            $user = new User();
            $user->name =  $faker->name();
            $user->email = $faker->email;
            $user->phone = $faker->phoneNumber();
            $user->status = '1';
            $user->dob = "12/24/1992";
            $user->gender = "male";
            $user->password = Hash::make('password');
            $user->role_id = 1;
            $user->save();

            $userInformation = new UserInformation();
            $userInformation->user_id = $user->id;
            $userInformation->save();


            $userInterest = new UserInterests();
            $userInterest->user_id = $user->id;
            $userInterest->interest_id = 1;
            $userInterest->save();

            unset($user);
            unset($userInformation);
            unset($userInterest);
        }
    }
}
