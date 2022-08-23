<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\Language;
use App\Models\Subcategory;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{
    public function index(Request $request)
    {
//        $countries = Country::orderBy('title_'.App::currentLocale(), 'asc')->get();
        $data = null;
        $data['categories'] = Category::orderBy('title_' . App::currentLocale())->get();
        $data['subcategories'] = Subcategory::orderBy('title_' . App::currentLocale())->get();
        $data['languages'] = Language::orderBy('title_' . App::currentLocale(), 'asc')->get();
        if (!$request['location']) {
            $request['location'] = 'Spain';
        }
        $data['location'] = $request['location'];
        $data['current_category'] = $request['category_id'];
        $data['current_subcategory'] = $request['subcategory_id'];
        $data['current_language'] = $request['lang'];
        $google = new GoogleController();
        $myPosition = $google->getCoordinates($data['location']);
//        $list = $this->userList($request, $myPosition);
//        $data['list'] = $list;
        if (!$myPosition) {
            return back()->withInput();
        }
        $data['myLocation'] = $myPosition;
        $filter = [];
        if ($request['category_id']) {
            $filter['category_id'] = $request['category_id'];
        }
        if ($request['lang']) {
            $changeLang = Language::where('id', $request['lang'])->first();
            App::setLocale($changeLang['key']);
            $this->lang = $request['lang'];
            $this->subcategory_id = $request['subcategory_id'];
            $users = User::where($filter)->where('role', '!=', 'admin')->whereHas('languages', function ($query) {
                $query->where('language_id', $this->lang);
            })->get();
            if ($request['subcategory_id']) {
                $users = User::where($filter)->where('role', '!=', 'admin')->whereHas('languages', function ($query) {
                    $query->where('language_id', $this->lang);
                })->whereHas('services', function ($query) {
                    $query->where('subcategory_id', $this->subcategory_id);
                })->get();
            }
        } else if ($request['subcategory_id']) {
            $this->subcategory_id = $request['subcategory_id'];
            $users = User::where($filter)->where('role', '!=', 'admin')->whereHas('services', function ($query) {
                $query->where('subcategory_id', $this->subcategory_id);
            })->get();
        } else {
            $users = User::where($filter)->where('role', '!=', 'admin')->get();
        }
        if ($users->isEmpty()) {
            $data['users'] = [];
        }
        foreach ($users as $user) {
            $data['users'][] = [
                'geo' => json_decode($user->coordinates, true),
                'contacts' => $user['email'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'category' => $user->category,
                'id' => $user['id'],
                'avatar' => $user['avatar'],
                'languages' => $user->languages,
                'rating' => $user->getRating(),
                'subcategory' => $user->services
            ];
        }
//        dd($data);
        return view('search', ['data' => $data]);
    }


    public function userList($request, $location)
    {
        if ($location) {
            $filter['city_coordinates'] = json_encode($location);
        }
        if ($request['category_id']) {
            $filter['category_id'] = intval($request['category_id']);
        }
        if ($request['lang']) {
            $this->lang = $request['lang'];
            $users = User::whereHas('languages', function ($query) {
                $query->where('language_id', $this->lang);
            })->paginate(10);
        } else $users = User::paginate(10);
        return $users;
    }

}
