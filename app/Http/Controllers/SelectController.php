<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;

class SelectController extends Controller
{
    public function getCountries(){
        return Country::orderBy('title', 'asc')->get();
    }

    public function getCategories(){
        return Category::all();
    }
}
