<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Review;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function homePage(){
        $country = Country::orderBy('title', 'asc')->get();
        $category = Category::orderBy('title', 'asc')->get();
        $reviews_list = Review::where('isActive', true)->latest()->limit(3)->get();
        $reviews = null;
        foreach ($reviews_list as $item){
            $reviews[] = [
                'name' => $item['name'],
                'text' => $item['text'],
                'rank' => $item['rank'],
                'for_user' => $item->user()
            ];
        }
        return view('welcome', compact('category', 'country', 'reviews'));
    }
}
