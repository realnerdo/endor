<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Storage;
use App\Setting;
use App\Picture;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|max:30|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'sidebar_logo' => 'required',
            'estimate_logo' => 'required',
            'title' => 'required',
            'store_url' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'observations' => 'required',
            'tax' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $sidebar_logo_url = $data['sidebar_logo']->store('public/logo');
        $sidebar_logo = Picture::create([
            'original_name' => $data['sidebar_logo']->getClientOriginalName(),
            'url' => str_replace('public/', '', $sidebar_logo_url)
        ]);
        $estimate_logo_url = $data['estimate_logo']->store('public/logo');
        $estimate_logo = Picture::create([
            'original_name' => $data['estimate_logo']->getClientOriginalName(),
            'url' => str_replace('public/', '', $estimate_logo_url)
        ]);

        $setting = Setting::create([
            'title' => $data['title'],
            'store_url' => $data['store_url'],
            'owner' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'observations' => $data['observations'],
            'tax' => $data['tax'],
            'sidebar_logo_id' => $sidebar_logo->id,
            'estimate_logo_id' => $estimate_logo->id
        ]);

        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'admin'
        ]);
    }
}
