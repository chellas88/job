<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleController;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Language;
use App\Models\LanguageUser;
use App\Models\NewUserLink;
use App\Models\Subcategory;
use App\Models\SubcategoryUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic;

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
    public function store(UserRequest $request)
    {
        $password = str_shuffle('i@!o28n954n727b8b;&%v7vjvnr');
        $user_data = $request->except('_token', 'avatar', 'lang_1', 'lang_2', 'lang_3');
        $google = new GoogleController();
        $user_data['coordinates'] = json_encode($google->getCoordinates($request['state'] . ' ' . $request['city'] . ' ' . $request['address']));
        $user_data['city_coordinates'] = json_encode($google->getCoordinates($request['city']));
        $user_data['password'] = Hash::make($password);
        $user = User::create($user_data);

        if ($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = $user['id'] . '.' . $avatar->getClientOriginalExtension();
            $path = "uploads/avatars/";
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            ImageManagerStatic::make($avatar)->resize(200, 200)->save(public_path($path) . $filename);
            $user->avatar = $filename;
            $user->save();
        }

        if ($request['profession_1']){
            SubcategoryUser::create([
                'user_id' => $user['id'],
                'subcategory_id' => $request['profession_1']
            ]);
        }
        if ($request['profession_2']){
            SubcategoryUser::create([
                'user_id' => $user['id'],
                'subcategory_id' => $request['profession_2']
            ]);
        }
        if ($request['profession_3']){
            SubcategoryUser::create([
                'user_id' => $user['id'],
                'subcategory_id' => $request['profession_3']
            ]);
        }
        if ($request['lang_1']){
            LanguageUser::create([
                'user_id' => $user['id'],
                'language_id' => $request['lang_1']
            ]);
        }
        if ($request['lang_2']){
            LanguageUser::create([
                'user_id' => $user['id'],
                'language_id' => $request['lang_2']
            ]);
        }
        if ($request['lang_3']){
            LanguageUser::create([
                'user_id' => $user['id'],
                'language_id' => $request['lang_3']
            ]);
        }

        Contact::create([
            'user_id' => $user['id'],
            'phone' => $request['phone'],
            'whatsapp' => $request['whatsapp'],
            'viber' => $request['viber'],
            'telegram' => $request['telegram'],
            'skype' => $request['skype'],
            'facebook' => $request['facebook'],
            'instagram' => $request['instagram'],
            'youtube' => $request['youtube']
        ]);
        NewUserLink::create([
            'user_id' => $user['id'],
            'link' => str_shuffle('ioj34v28n954n727b8bv27vjvnr'),
            'password' => $password
        ]);
        $msg = request()->session();
        $msg->flash('success', 'Пользователь создан успешно');
        return redirect()->route('user.index');

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
