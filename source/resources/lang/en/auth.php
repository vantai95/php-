<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials are incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'permission_denied' => 'You do not have permission to access this page.',
    'register' => [
        'title' => 'Register',
        'full_name' => 'Full Name',
        'password' => "Password",
        'confirm_password' => "Confirm Password",
        'email' => 'Email Address',
        'button' => 'Register',
        'validate_full_name' => 'Name is not allow special character, number '
    ],
    'login' => [
        'title' => 'Login',
        'email' => 'E-Mail Address',
        'password' => "Password",
        'remember_me' => 'Remember Me',
        'forget_password' => 'Forgot Your Password?',
        'button' => 'Login'
    ],
    'reset' => [
        'title' => 'Reset Password',
        'email' => 'E-Mail Address',
        'password' => "Password",
        'confirm_password' => "Confirm Password",
        'button' => 'Reset Password'
    ],
    'email' => [
        'title' => 'Reset Password',
        'email' => 'E-Mail Address',
        'button' => 'Send Password Reset Link'
    ],
    'socialite' => [
        'sign_in_with_facebook' => 'Sign In With Facebook',
        'sign_in_with_google' => 'Sign In With Google+',
        'register_with_facebook' => 'Register With Facebook',
        'register_with_google' => 'Register With Google+',
    ],
    'flash_message' => [
        'success' => 'You have login successfully!',
        'failed' => 'You don\'t have permission to access this page!'
    ]
];
