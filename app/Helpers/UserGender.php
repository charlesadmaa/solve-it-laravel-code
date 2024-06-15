<?php
namespace App\Helpers;

enum UserGender : String
{
    case STATE_MALE = "male";
    case STATE_FEMALE = "female";


    public function getUserGender(){
        return match($this){
            self::STATE_MALE => "male",
            self::STATE_FEMALE => "female",
        };
    }
}
