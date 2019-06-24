<?php

function view($resource, $data = null) {
    // Replacing dots with slashes
    $resource = str_replace('.', "/", $resource);
    // Making the path to the include
    $path = __DIR__ . "/../resources/$resource.visual.php";
    // Extracting data from the variable
    if ($data) extract($data);
    // Including the file
    if (($exists = file_exists($path))) include_once($path);
    // After showing the view destroys the errors
    unset($_SESSION['message']);
    // Returning if it exists
    return $exists;
}

function get_user_id() {
    // Getting the current user id
    if (($output = isset($_SESSION['id']))) $output = $_SESSION['id'];
    // Returning the id
    return $output;
}

function redirect($route, $msg = null) {
    // Setting the message via cookie
    if (!empty($msg)) $_SESSION['message'] = $msg;
    // Redirecting to the required location
    header("Location: " . route($route));
}

function get_error($name) {
    // Checking if it exists then showing
    if (has_error($name)) return $_SESSION['message'][$name];
    else return false;
}

function has_error($name) {
    // Checking if it has any error
    return isset($_SESSION['message'][$name]);
}

function route($name, $output = true) {
    // Replacing double slashes to prettify the url
    $name = BASE_URL . preg_replace("/[\/]+/", '/', '/' . $name);
    // Assigning the return value
    $url = "http://{$name}";
    // If output is true, it will print on the screen
    if ($output) print $url;
    // Returning the value
    return $url;
}

function show(&$string, $default = null) {
    $output = $default;
    if (isset($string)) $output = $string;
    // Should display escaped html
    print(htmlspecialchars($output));
}

function abort($code) {
    http_response_code($code);
    // Displaying the errors route
    view("errors.$code");
    exit();
}