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
        $google = new GoogleController();
        $coordinates = $google->getCoordinates($user['state'] . ' ' . $user['city'] . ' ' . $user['address']);
        $data['coordinates'] = $coordinates;
        $data['user'] = $user;
        $data['category'] = $user->category;
        return view('home' , ['data' => $data]);
    }
}
