<?php

namespace System;

use App\Controller\Controller;
use App\Model\User;

class Request {

    private $args;

    private $user;

    private $http_data;

    public $method;

    public function __construct($method = null) {
        // If method was not defined set to the current
        if (empty($method)) $method = $_SERVER['REQUEST_METHOD'];
        // Setting the request method variable
        $this->set_method($method);
        // Retrieving all the requested fields in that method
        $this->set_http_data($this->method);
    }

    public function all() {
        // Returning all the data in the request
        return $this->http_data;
    }

    /**
     * @return User
     */
    public function get_user() {
        return $this->user;
    }

    private function set_method($method) {
        // Handling to avoid inconsistency
        $method = strtolower($method);
        // Setting the global method variable to retrieve via post
        if ($method == 'post') $this->method = INPUT_POST;
        // Setting the global method variable to retrieve via get
        if ($method == 'get') $this->method = INPUT_GET;
    }

    private function set_http_data($method) {
        // Getting all variables depending on the method
        $this->http_data = ($method == INPUT_POST) ? $_POST : $_GET;
    }

    public function set_user($user) {
        if ($user instanceof User) $this->user = $user;
    }

    public function get_args() {
        return $this->args;
    }

    public function set_args($args) {
        $this->args = $args;
    }

}