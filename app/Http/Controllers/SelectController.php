<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SelectController extends Controller
{
    public function getCountries(){
        return Country::orderBy('title_' . App::currentLocale(), 'asc')->get();
    }

    public function getCategories(){
        return Category::orderBy('title_' . App::currentLocale(), 'asc')->get();
    }

    public function getLanguages(){
        return Language::orderBy('title_' . App::currentLocale(), 'asc')->get();
    }
}
