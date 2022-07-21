<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{
    public function index(SearchRequest $request)
    {
        $categories = Category::orderBy('title_'.App::currentLocale(), 'asc')->get();
        $countries = Country::orderBy('title_'.App::currentLocale(), 'asc')->get();
        $data = null;
        $data['categories'] = $categories;
        $data['countries'] = $countries;
        $data['location'] = $request['city'];
        $data['current_category'] = $request['category_id'];
        $data['current_country'] = $request['country_id'];
        $google = new GoogleController();
        $myPosition = $google->getCoordinates($data['location']);
        $list = $this->userList($request, $myPosition);
        $data['list'] = $list;
        if (!$myPosition) {
            return back()->withInput();
        }
        $data['myLocation'] = $myPosition;
        $filter = [
            'country_id' => $request['country_id']
        ];
        if ($request['category_id']) {
            $filter['category_id'] = $request['category_id'];
        }
        $users = User::where($filter)->get();
        if ($users->isEmpty()) {
            $data['users'] = null;
        }
        foreach ($users as $user) {
            $data['users'][] = [
                'geo' => json_decode($user->coordinates, true),
                'contacts' => $user['email'],
                'name' => $user['name'],
                'surname' => $user['surname'],
                'category' => $user->category,
                'id' => $user['id']
            ];
        }
        return view('search', ['data' => $data]);
    }


    public function userList($request, $city)
    {
        $filter = [
            'country_id' => intval($request['country_id']),
        ];
        if ($city) {
            $filter['city_coordinates'] = json_encode($city);
        }
        if ($request['category_id']) {
            $filter['category_id'] = intval($request['category_id']);
        }
        $users = User::where($filter)->paginate(10);
        return $users;
    }

}
