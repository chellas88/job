<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        if ($contacts->isEmpty()){
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

        $select = new SelectController();
        $data['categories'] = $select->getCategories();
        $data['countries'] = $select->getCountries();
        return view('home' , ['data' => $data]);
    }
}
