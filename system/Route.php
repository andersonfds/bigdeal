<?php /** @noinspection PhpIncludeInspection */

namespace System;

use App\Controller\LoginController;

require_once 'functions.php';
require_once '../app/controller/Controller.php';
require_once '../app/controller/LoginController.php';
require_once '../app/Auth.php';

class Route {

    private $current_url;
    private $path;
    private $method;
    private $ctrl;
    private $args = [];
    private $user;

    private function __construct($url) {
        $this->current_url = $url;
    }

    public static function on($method, $path, $ctrl) {
        // Getting the current url on the browser
        $url = self::getUrlPath();
        // Creating a new instance of the router
        $output = new Route($url);
        $output->path = $path . '/?';
        $output->ctrl = $ctrl;
        $output->method = strtoupper($method);
        // Returning a new instance of the router
        return $output;
    }

    public static function getUrlPath() {
        // Returning the current url in the address bar
        return $_SERVER['REDIRECT_URL'];
    }

    public function run($level = 0) {
        // Checks if the current method is the requested by the route
        $valid_method = $_SERVER['REQUEST_METHOD'] == $this->method || $this->method == "ANY";
        if ($this->match($this->path) && $valid_method) {
            // If should authenticate it will check or die
            $this->checkAuth($level);
            // Getting the className and the method
            $ctrl = explode('@', $this->ctrl);
            // Creating a new instance of the class
            $this->call($ctrl[0], $ctrl[1]);
            // Dying, since don't need to process anymore
            exit();
        }
    }

    public function match($path) {
        // Validating the regular expression
        $path = $this->valid_regex($path);
        // Checking if it matches with the current URL
        if (($output = preg_match($path, $this->current_url, $arg)))
            // Checking and assigning any arguments
            for ($i = 1; $i < sizeof($arg); $i++) $this->args[] = $arg[$i];
        // Returning the preg_match boolean value
        return $output;
    }

    private function valid_regex($string) {
        // Checking if the string does not start with a slash
        if (($t = substr($string, 0, 1) !== '/'))
            // Adding a slash in positive case
            $string = "/{$string}";
        // Returning the valid Regex
        return "#^{$string}$#";
    }

    private function checkAuth($authenticate) {
        // Instantiating a login controller
        $ctrl = new LoginController();
        // Setting the user variable
        $this->user = $ctrl->getSession();

        if (!empty($authenticate)) {
            // If not authenticated
            if (empty($this->user)) abort(404);
            // If has no level enough
            if ($this->user->level < $authenticate) abort(404);
        }
    }

    private function call($classPath, $method) {
        // Base path to controllers folder
        $controllers = __DIR__ . "/../app/controller";
        // Setting up the class name with the namespace
        $className = "App\\Controller\\$classPath";
        // Setting up the class path
        $classPath = "{$controllers}/$classPath.php";
        // Including the file into the document
        if ($this->grab_file($classPath)) {
            // Calling the method on the class
            $this->call_method($className, $method);
        }
    }

    private function grab_file($file) {
        // Checking if the file exists and including it
        if (($output = file_exists($file)))
            // Including the requested file
            include_once($file);
        // Returning the output
        return $output;
    }

    private function call_method($class, $method) {
        // Checking if the class and method exists
        if (is_callable([$class, $method])) {
            // Getting the output of the call if not empty
            $object = new $class();
            $argv = $this->build_args();
            $output = $object->$method($argv);
            // it will treat the document as text if has output
            if ($output) $this->json($output);
        }
    }

    private function build_args() {
        $request = new Request();
        $request->set_user($this->user);
        $request->set_args($this->args);
        return $request;
    }

    private function json($data) {
        // Setting the content type to be a text output
        header('Content-type: text/plain');
        // Printing the json data
        print(json_encode($data));
    }

}
