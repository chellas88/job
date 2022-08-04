<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Contact;
use App\Models\Language;
use App\Models\LanguageUser;
use App\Models\NewUserLink;
use App\Models\SubcategoryUser;
use App\Models\User;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
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
//        $city_coordinates = json_encode($google->getCoordinates($request['city']));
        $user = Auth::user();
        $user->country_id = $request['country_id'];
        $user->city = $request['city'];
        $user->state = $request['state'];
        $user->coordinates = $coordinates;
//        $user->city_coordinates = $city_coordinates;
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
//        $contacts = $user->contacts;
//        if (!$contacts) {
//            $data['warning']['contacts'] = true;
//        }
        $google = new GoogleController();
        $coordinates = $google->getCoordinates($user['state'] . ' ' . $user['city'] . ' ' . $user['address']);
        $data['coordinates'] = $coordinates;
        $data['user'] = $user;
        $data['category'] = $user->category;
        $data['contacts'] = $user->contacts;
        $data['services'] = $user->services;
        $data['languages'] = $user->languages;
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

    public function privacy($link){
        $nav = NewUserLink::where('link', $link)->first();
        if (!$nav){
            return redirect('/');
        }
        $user = $nav->user;
        return view('accept_privacy', compact('user'));
    }

    public function accept(Request $request){
        if ($request['user']){
            User::where('id', $request['user'])->update(['policy' => true]);
            NewUserLink::where('user_id', $request['user'])->delete();
            return redirect()->route('home');
        }
        return redirect()->back();
    }

    public function Step2(Request $request){
        $user_id = Auth::user()->id;
        $services = [];
        if ($request['category_id']){
            User::where('id', $user_id)->update(['category_id' => $request['category_id']]);
            if ($request['subcategory_1']){
//                array_push($services, [
//                    'user_id' => $user_id,
//                    'subcategory_id' => $request['subcategory_1']
//                ]);
                SubcategoryUser::create([
                    'user_id' => $user_id,
                    'subcategory_id' => $request['subcategory_1']
                ]);
            }
            if ($request['subcategory_2']){
//                array_push($services, [
//                    'user_id' => $user_id,
//                    'subcategory_id' => $request['subcategory_2']
//                ]);
                SubcategoryUser::create([
                    'user_id' => $user_id,
                    'subcategory_id' => $request['subcategory_2']
                ]);
            }
            if ($request['subcategory_3']){
//                array_push($services, [
//                    'user_id' => $user_id,
//                    'subcategory_id' => $request['subcategory_3']
//                ]);
                SubcategoryUser::create([
                    'user_id' => $user_id,
                    'subcategory_id' => $request['subcategory_3']
                ]);
            }
        }
        return redirect(route('home'));
    }

    public function Step3(Request $request){
        $google = new GoogleController();
        $request['coordinates'] = json_encode($google->getCoordinates($request['country'] . ' ' . $request['state'] . ' ' . $request['city'] . ' ' . $request['address']));
//        $request['city_coordinates'] = json_encode($google->getCoordinates($request['country'] . ' ' . $request['state'] . ' ' . $request['city']));
        User::where('id', Auth::user()->id)->update($request->except('_token'));
        return redirect(route('home'));
    }

    public function Step4(Request $request){
        $request['user_id'] = Auth::user()->id;
        if($request['phone']){
            Contact::create($request->except('_token'));
        }
        return redirect(route('home'));
    }

    public function Step5(Request $request){
        $user_id = Auth::user()->id;
        if ($request['lang_1']){
            $keylang_id = $request['keylang_1'];
            User::where('id', $user_id)->update([
                'title_' . $keylang_id => $request['profile_title_1'],
                'description_' . $keylang_id => $request['description_1']
            ]);
            LanguageUser::create([
                'user_id' => $user_id,
                'language_id' => $request['lang_1']
            ]);
        }
        if ($request['lang_2']){
            $keylang_id = $request['keylang_2'];
            User::where('id', $user_id)->update([
                'title_' . $keylang_id => $request['profile_title_2'],
                'description_' . $keylang_id => $request['description_2']
            ]);
            LanguageUser::create([
                'user_id' => $user_id,
                'language_id' => $request['lang_2']
            ]);
        }
        if ($request['lang_3']){
            $keylang_id = $request['keylang_3'];
            User::where('id', $user_id)->update([
                'title_' . $keylang_id => $request['profile_title_3'],
                'description_' . $keylang_id => $request['description_3']
            ]);
            LanguageUser::create([
                'user_id' => $user_id,
                'language_id' => $request['lang_3']
            ]);
        }
        return redirect(route('home'));
    }


    public function getContact(Request $request){
        $user = User::find($request['user_id']);
        $val = null;
        if ($request['type'] == 'email'){
            $email = $user->email;
            $val = "<a href='mailto:". $email ."'> ". $email ." </a>";
        }
        if ($request['type'] == 'phone'){
            $phone = $user->contacts->phone;
            $val = "<a href='tel:+496170961709'>$phone</a>";
        }
        if ($request['type'] == 'viber'){
            $number = str_replace('+', '', $user->contacts->viber);
            $val = "<a href='viber://add?number=". $number."'>Viber</a>";
        }
        if ($request['type'] == 'whatsapp'){
            $whatsapp = $user->contacts->whatsapp;
            $val = "<a href='https://wa.me/". $whatsapp ."'> ". __('main.write_to_whatsapp') ."</a>";
        }
        if ($request['type'] == 'telegram'){
            $telegram = $user->contacts->telegram;
            $val = "<a href='tg://resolve?domain=chellas88'>". __('main.write_to_telegram')."</a>";
        }
        $data = [
            'type' => $request['type'],
            'val' => $val
        ];
        return $data;


    }
}
