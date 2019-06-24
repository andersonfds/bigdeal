<?php

use App\Controller\LoginController;

require_once __DIR__ . '/model/User.php';

class Auth {

    public static function user() {
        return (new LoginController())->getSession();
    }

    public static function ok() {
        return isset($_SESSION['identifier']) and isset($_SESSION['password']);
    }

}