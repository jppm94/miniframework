<?php

class RegisterController
{
    public static function showRegistrationForm()
    {
        return view('auth/register');
    }

    public static function register()
    {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];

        Auth::register($username, $password);

        redirect();
    }
}