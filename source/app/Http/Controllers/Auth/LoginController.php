<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use League\Flysystem\Config;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if (session()->has('redirect_url')) {
            return session()->pull('redirect_url');
        } else {
            if (Auth::user()->isAdmin()) {
                return '/admin';
            } else {
                return '/';
            }
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Socialite Login
     *
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        Session::flash('flash_message',trans('auth.flash_message.success'));
        return redirect('/');
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('fb_uid', $user->id)
            ->orWhere('email', $user->getEmail())
            ->first();

        if ($authUser) {
            return $authUser;
        } elseif ($provider == 'facebook') {
            return User::create([
                'full_name' => $user->name,
                'email' => $user->email,
                'fb_uid' => $user->id,
                'has_password' => false,
                'image_1' => $user->avatar_original
            ]);
        } else {
            return User::create([
                'full_name' => $user->getName(),
                'email' => $user->getEmail(),
                'google_uid' => $user->token,
                'image_1' => $user->getAvatar(),
                'password' => bcrypt('123456')
            ]);
        }
    }

    public function logout(){
        $user = Auth::user();
        $redirectlink = $user->role_id == 1 ? '/login' : '/';
        Auth::logout();
        return redirect($redirectlink);
    }

    /*load config login facebook and google
    */
    public function showLoginForm()
    {
        return view('auth.login');
    }
}
