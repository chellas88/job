<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Country;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Stichoza\GoogleTranslate\GoogleTranslate;

class IndexController extends Controller
{
    public function homePage(){
        $country = Country::orderBy('title_' .App::currentLocale(), 'asc')->get();
        $category = Category::orderBy('title_'.App::getLocale())->get();
        $languages = SelectController::getLanguages();
        $personsCount = User::where('role', 'person')->count();
        $companiesCount = User::where('role', 'company')->count();
        $countriesCount = $country->count();
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
        return view('welcome', compact('category', 'country', 'reviews', 'recommended', 'personsCount', 'companiesCount', 'countriesCount', 'languages'));
    }

    public function policyPage(){
        $tr = new GoogleTranslate(App::currentLocale());
        $tr->setSource('ru');
        $article = Article::where('name', 'policy')->first();
//        $policy = $tr->translate($article);
        return view('policy', compact('article'));
    }

    public function rulesPage(){
        return 'rules';
    }
}
