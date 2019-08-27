<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Notifications\PasswordResetRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Reset password view
     */
    public function resetPage(){
        return view('auth.passwords.email');
    }

    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */

    public function create(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            Session::flash('flash_error', 'We can\'t find a user with that e-mail address.');
            return redirect()->back();
        }

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]
        );

        if ($user && $passwordReset)
            $user->notify(
                new PasswordResetRequest($passwordReset->token)
            );
        Session::flash('flash_message', 'We have e-mailed your password reset link!');

        return redirect('/login');
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset){
            return view('auth.verify.invalid');
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return view('auth.verify.invalid');
        }

        return view('auth.passwords.reset',compact('token'));
    }
}
