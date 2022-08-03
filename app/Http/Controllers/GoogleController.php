<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    public function getCoordinates($address)
    {
        $address = str_replace(' ', '+', $address);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=" . config('google.key');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_PROXY, '10.2.120.21:3131');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($output, true);
        if (($res['status'] == 'OK') && ($res != null)) {
            return $res['results'][0]['geometry']['location'];
        }
        return false;
    }

    public function googleRedirect(){
        return Socialite::driver('google')->redirect();
    }

    public function loginWithGoogle(){
        try {
            $user = Socialite::driver('google')->user();
            $isUser = User::where('google_id', $user->id)->first();
            if ($isUser){
                Auth::login($isUser);
                return redirect('/home');
            }
            $isEmail = User::where('email', $user->email)->first();
            if ($isEmail){
                User::where('email', $user->email)->update([
                    'google_id' => $user->id
                ]);
                Auth::login($isEmail);
                return redirect('/home');
            }

                $createUser = User::updateOrCreate([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => Hash::make('us'),
                    'google_id' => $user->id
                ]);
                Auth::login($createUser);
                return redirect('/home');

        } catch (Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function getLocation(Request $request){

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $request['lat'] . "," . $request['lng'] . "&key=" . config('google.key');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_PROXY, '10.2.120.21:3131');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true)['results'][0]['formatted_address'];
    }
}
