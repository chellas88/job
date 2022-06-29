<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class IndexController extends Controller
{
    public function homePage(){
        $country = Country::orderBy('title', 'asc')->get();
        $category = Category::orderBy('title_'.App::getLocale())->get();
        $reviews_list = Review::where('isActive', true)->latest()->limit(3)->get();
        $recommended = User::recommended();
        $reviews = null;
        foreach ($reviews_list as $item){
            $reviews[] = [
                'name' => $item['name'],
                'text' => $item['text'],
                'rank' => $item['rank'],
                'for_user' => $item->user()
            ];
        }
        return view('welcome', compact('category', 'country', 'reviews', 'recommended'));
    }
}
