<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Language;
use App\Models\NewUserLink;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $countries = Country::orderBy('title_'.App::currentLocale(), 'asc')->get();
        $categories = Category::orderBy('title_'.App::currentLocale(), 'asc')->get();
        return view('admin.users.index', compact('users', 'countries', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professions = Category::where('user_type', 'person')->get();
        $services = Category::where('user_type', 'company')->get();
        $countries = Country::orderBy('title_'.App::currentLocale(), 'asc')->get();
        $subcategories = Subcategory::orderBy('title_'.App::currentLocale(), 'asc')->get();
        $langs = Language::orderBy('title_'.App::currentLocale(), 'asc')->get();
        return view('admin.users.create', compact('professions', 'services', 'countries', 'subcategories', 'langs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['password'] = Hash::make('test');
        $user = User::create($request->except('_token'));
        NewUserLink::create([
            'user_id' => $user['id'],
            'link' => str_shuffle('bu47ih289h22d29')
        ]);
        return redirect()->route('user.edit', $user['id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('admin.users.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        User::where('id', $id)->update($request->except('_token', '_method'));

        if ($request['_token']){
            $msg = request()->session();
            $msg->flash('success', 'Категория успешно изменена');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
