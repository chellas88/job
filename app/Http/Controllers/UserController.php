<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Contact;
use App\Models\Language;
use App\Models\LanguageUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic;

class UserController extends Controller
{
    public function saveUser(Request $request)
    {
        $user = Auth::user();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->category_id = $request['category_id'];
        $user->save();
        $langs = Language::all();
        $msg = request()->session();
        $msg->flash('success', 'User data was changed');
        return redirect()->back();
    }


    public function uploadAvatar(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = Auth::id() . '.' . $avatar->getClientOriginalExtension();
            $path = "uploads/avatars/";
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            ImageManagerStatic::make($avatar)->resize(200, 200)->save(public_path($path) . $filename);
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }
        $msg = request()->session();
        $msg->flash('success', 'Avatar was changed');
        return redirect()->back();
    }

    public function saveAddress(AddressRequest $request)
    {
        $google = new GoogleController();
        $coordinates = json_encode($google->getCoordinates($request['state'] . ' ' . $request['city'] . ' ' . $request['address']));
        $city_coordinates = json_encode($google->getCoordinates($request['city']));
        $user = Auth::user();
        $user->country_id = $request['country_id'];
        $user->city = $request['city'];
        $user->state = $request['state'];
        $user->coordinates = $coordinates;
        $user->city_coordinates = $city_coordinates;
        $user->address = $request['address'];
        $user->save();
        $msg = request()->session();
        $msg->flash('success', 'Address was changed');
        return redirect()->back();
    }

    public function profile(User $id)
    {
        $user = $id;
        $data = null;
        $contacts = $user->contacts;
        if ($contacts->isEmpty()) {
            $data['warning']['contacts'] = true;
        }
        $google = new GoogleController();
        $coordinates = $google->getCoordinates($user['state'] . ' ' . $user['city'] . ' ' . $user['address']);
        $data['coordinates'] = $coordinates;
        $data['user'] = $user;
        $data['category'] = $user->category;
        return view('profile', ['data' => $data]);
    }

    public function removeLanguage(Request $request){

    }

    public function saveContacts(Request $request){
        $user = Auth::user()->id;
        $contacts = Contact::where('user_id', $user)->get();
        if ($contacts->isEmpty()){
            $request['user_id'] = $user;
            Contact::create($request->except('_token'));
        }
        else {
            Contact::where('user_id', $user)->update($request->except('_token'));
        }
        return redirect()->back();
    }
}
