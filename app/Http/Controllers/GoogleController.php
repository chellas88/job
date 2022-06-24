<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function getCoordinates($address)
    {
        $address = str_replace(' ', '+', $address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=" . config('google.key');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
// SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($output, true);
        if ($res['status'] == 'OK') {
            return $res['results'][0]['geometry']['location'];
        }
        return false;
    }
}
