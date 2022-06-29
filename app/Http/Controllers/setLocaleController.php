<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class setLocaleController extends Controller
{
    public function setLocale(Request $request, $lang){
//        if (in_array($lang, config('app.locales'))){
//            Cookie::queue('lang', $lang, 500000);
//        }
    }
}
