<?php

require_once '../app/model/Model.php';
require_once '../app/model/User.php';
require_once '../app/controller/Controller.php';
require_once '../system/Storage.php';
require_once '../system/Request.php';
require_once '../system/Route.php';
require_once '../routes.php';

// Showing the error file
view('errors.404');