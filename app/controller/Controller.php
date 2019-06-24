<?php

namespace App\Controller;

use App\CRUD\DB;
use App\Model\User;
use PDO;

class Controller {

    public function getSession() {
        // Checking if the cookie is there
        if (isset($_SESSION['identifier']) && isset($_SESSION['password'])) {
            $email = $_SESSION['identifier'];
            $psw = $_SESSION['password'];
            // Returning if the user exists
            return $this->auth($email, $psw);
        } else return false;
    }

    /**
     * @param $id
     * @param $psw
     * @return User|bool
     */
    public function auth($id, $psw) {
        // Building the Select Query
        $SQL = DB::table('users')->select(['*'])->limit(1);
        $SQL->where('email = ? AND password = ?');
        // Connecting and executing the SQL
        $db = DB::connect()->prepare($SQL->build());
        $db->execute([$id, $psw]);
        // Returning the user or false
        $user = $db->fetch(PDO::FETCH_ASSOC);
        // Returning if the user is working
        if (!$user) return false;
        return (new User())->fillAll($user);
    }

    public function setAuthCookies($email, $psw, $id) {
        $_SESSION['identifier'] = $email;
        $_SESSION['password'] = $psw;
        $_SESSION['id'] = $id;
    }

    public function dropAuthCookies() {
        // Resetting the cookies
        unset($_SESSION['identifier']);
        unset($_SESSION['password']);
        unset($_SESSION['id']);
    }
}