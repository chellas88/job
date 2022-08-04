<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $data = null;
        $contacts = $user->contacts;
        if (!$contacts){
            $data['warning']['contacts'] = true;
        }

        if ($user->coordinates == null){
            $data['warning']['coordinates'] = true;
        }
        if ($user->category_id == null){
            $data['warning']['category'] = true;
        }
//        $google = new GoogleController();
//        $coordinates = $google->getCoordinates($user['state'] . ' ' . $user['city'] . ' ' . $user['address']);

        $data['coordinates'] = json_decode($user->coordinates, true);
        $data['user'] = $user;
        $data['category'] = $user->category;
        $data['my_languages'] = $user->languages;
        $data['my_services'] = $user->services;
        $select = new SelectController();
        $data['categories'] = Category::where('user_type', $user->role)->orderBy('title_'.App::currentLocale(), 'asc')->get();
        $services = Subcategory::where('category_id', $data['category']->id)->orderBy('title_'.App::currentLocale(), 'asc')->get();
        $data['services'] = [];
        foreach ($services as $serv){
            $is = false;
            foreach ($data['my_services'] as $myserv){
                if ($serv['id'] == $myserv['id']){
                    $is = true;
                }
            }
            if (!$is){
                $data['services'][] = $serv;
            }
        }
        $data['languages'] = [];
        $languages = Language::orderBy('title_'. App::currentLocale(), 'asc')->get();
        foreach ($languages as $lang){
            $is = false;
            foreach ($data['my_languages'] as $mylang){
                if ($lang['id'] == $mylang['id']){
                    $is = true;
                }
            }
            if (!$is){
                $data['languages'][] = $lang;
            }
        }
//        dd($data);
        return view('home' , ['data' => $data]);
    }


}
