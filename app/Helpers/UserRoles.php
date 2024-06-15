<?php
namespace App\Helpers;

enum UserRoles : Int
{
    case STATE_STUDENT = 1;
    case STATE_LECTURER = 2;
    case STATE_SCHOOL_STAFF = 3;
    case STATE_GENERAL_PUBLIC = 4;
    case STATE_ADMIN = 5;
    case STATE_MODERATOR = 6;


    public function getUserRole(){
        return match($this){
            self::STATE_STUDENT => 1,
            self::STATE_LECTURER => 2,
            self::STATE_SCHOOL_STAFF => 3,
            self::STATE_GENERAL_PUBLIC => 4,
            self::STATE_ADMIN => 5,
            self::STATE_MODERATOR => 6,
        };
    }
}
