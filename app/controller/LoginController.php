<?php

namespace App\Controller;

class LoginController extends Controller {

    public function index() {
        // If is logged in it should go back to home
        if ($this->getSession()) redirect('/');
        // Otherwise shows the login form
        else view('auth.login');
    }

    public function login() {
        // If it's already authenticated it will go back
        if ($this->getSession()) redirect('/');
        // Getting via post method the needed variables
        $mail = filter_input(INPUT_POST, 'identifier', FILTER_VALIDATE_EMAIL);
        $psw = md5(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));
        // Authenticating and redirecting to the home route
        if ($mail && $psw && $user = $this->auth($mail, $psw)) {
            $this->setAuthCookies($user->email, $user->password, $user->id);
            redirect('/');
        }
        // In error case, it will go back with the error message
        redirect('login', ['login' => 'Usuário ou senha incorretos']);
    }

    public function logout() {
        // Dropping the authentication cookies
        if ($this->getSession()) $this->dropAuthCookies();
        // Redirecting back to the home route
        redirect('/');
    }

}