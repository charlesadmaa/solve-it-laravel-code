<?php

use App\Helpers\UserRoles;

function getUserRole($roleId){
    switch($roleId){
        case "6":
            return "Moderator";
            break;
        case "5":
            return "Administrator";
            break;
        case 4:
            return "General Public";
            break;
        case 3:
            return "School Staff";
            break;
        case 2:
            return "Lecturer";
            break;
        case 1:
            return "Student";
            break;
        default:
            return "General Public";
    }
}

function user()
{
    return Auth::guard('web')->user();
}
