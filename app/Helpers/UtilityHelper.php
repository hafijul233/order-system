<?php 

namespace App\Helpers;

class UtilityHelper 
{
    public static function platformIcon(string $platform) {
        
        return match ($platform) {
            'android' => "<span class='text-success'><i class='la la-android'></i> " . config("constant.platforms.{$platform}") . "</span>",
            'ios' => "<span class='text-success'><i class='la la-app-store-ios'></i> " . config("constant.platforms.{$platform}") . "</span>",
            'website' => "<span class='text-success'><i class='la la-globe-asia'></i> " . config("constant.platforms.{$platform}") . "</span>",
            'office' => "<span class='text-success'><i class='la la-building'></i> " . config("constant.platforms.{$platform}") . "</span>",
            'store' => "<span class='text-success'><i class='la la-store'></i> " . config("constant.platforms.{$platform}") . "</span>",
            default => "<span class='text-warning'><i class='la la-warning'></i>N/A</span>"
        };
    }
}