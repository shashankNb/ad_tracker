<?php

namespace App\Helpers;

class Helper
{
    public static function Country($ip_address): string
    {
        $geoPlugin = new GeoHelper();
        $geoPlugin->locate($ip_address);
        $countryCode = $geoPlugin->countryCode ?? 'LKL';
        return $geoPlugin->fetchCountry($countryCode);
    }

    public static function UserAgent(): string
    {
        $browser = 'Default';
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE (\d+\.\d+);/', $agent)) {
            $browser = "Internet Explorer";
        } else if (preg_match('/Chrome[\/\s](\d+\.\d+)/', $agent)) {
            $browser = "Chrome";
        } else if (preg_match('/Edg\/\d+/', $agent)) {
            $browser = "Edge";
        } else if (preg_match('/Firefox[\/\s](\d+\.\d+)/', $agent)) {
            $browser = "Firefox";
        } else if (preg_match('/OPR[\/\s](\d+\.\d+)/', $agent)) {
            $browser = "Opera";
        } else if (preg_match('/Safari[\/\s](\d+\.\d+)/', $agent)) {
            $browser = "Safari";
        }
        return $browser;
    }
}
