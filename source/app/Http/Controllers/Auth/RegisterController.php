<?php

namespace App\Http\Controllers\Auth;

use App\Models\Configuration;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Config;

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
    protected $redirectTo = '/home';

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ], $this->validationMessages());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $this->redirectTo = '/';
        Session::flash('flash_message', 'Registered successfully!');
        return User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    private function validationMessages()
    {
        return [
            'full_name.regex' => trans('auth.register.validate_full_name')
        ];
    }

    /*load config login facebook and google
     * */
    public function showRegistrationForm()
    {
        $login_facebook = Configuration::where('config_key','LOGIN_FACEBOOK')->first()->config_value;

        $login_google = Configuration::where('config_key','LOGIN_GOOGLE')->first()->config_value;

        return view('auth.register', compact('login_facebook', 'login_google'));
    }
}
