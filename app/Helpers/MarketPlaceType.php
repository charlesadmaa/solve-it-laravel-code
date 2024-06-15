<?php
namespace App\Helpers;

enum MarketPlaceType : String
{
    case STATE_PRODUCT = "product";
    case STATE_SERVICE = "service";


    public function getMarketPlaceType(){
        return match($this){
            self::STATE_PRODUCT => "product",
            self::STATE_SERVICE => "services",
        };
    }
}
