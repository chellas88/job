<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class FullRegisterController extends Controller
{
    public function step_2(Request $request){
        $user = Auth::user();
        $categories = Category::where('user_type', $user->role)->orderBy('title_' . App::currentLocale(), 'asc')->get();
        $subcategories = Subcategory::orderBy('title_' . App::currentLocale(), 'asc')->get();
        $services = [];
        foreach ($subcategories as $subcategory){
            $services[] = [
                'id' => $subcategory['id'],
                'title_'.App::currentLocale() => $subcategory['title_'. App::currentLocale()],
                'category_id' => $subcategory['category_id']
            ];
        }
        return view('auth.step2', compact('categories', 'services', 'user'));
    }


    public function step_3(Request $request){

        return view('auth.step3');
    }


    public function step_4(Request $request){

        return view('auth.step4');
    }

    public function step_5(Request $request){
        $languages = Language::orderBy('title_'.App::currentLocale(), 'asc')->get();
        $myLanguages = Auth::user()->languages;
        $translate = __('main');
        return view('auth.step5', compact('languages', 'myLanguages', 'translate'));
    }
}
