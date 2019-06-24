<?php

namespace App\Controller;

use App\Model\User;
use System\Request;

class RegisterController extends Controller
{

    public function index()
    {
        // If it is logged in should redirect to home
        if (self::getSession()) redirect('/');
        // Otherwise shows the register form
        else view('auth.register');
    }

    public function store(Request $request)
    {
        // Creating a new user
        $user = new User();
        // Filling only the public fields
        $user->fill($request->all());
        // Encrypting the password
        $user->password = md5($user->password);
        // Setting the user level to 1
        $user->level = 1;
        if ($user->save()) {
            // first user has master access
            if ($user->id == 1) {
                $user->level = 9;
                $user->save();
            }
            // Forcing authentication to the new user
            $this->setAuthCookies($user->email, $user->password, $user->id);
            // Redirecting back to the home route
            redirect('/');
        } else redirect('register', ['register' => 'Preencha todos os campos corretamente.']);
    }
}