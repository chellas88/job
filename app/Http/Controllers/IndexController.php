<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function homePage(){
        $country = Country::orderBy('title', 'asc')->get();
        $category = Category::orderBy('title', 'asc')->get();
        return view('welcome', compact('category', 'country'));
    }
}
