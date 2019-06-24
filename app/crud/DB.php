<?php

namespace App\CRUD;

use PDO;

// Database access file
require_once(__DIR__ . '/../../config.php');

// Database operation classes
require_once(__DIR__ . '/operator/Select.php');
require_once(__DIR__ . '/operator/Insert.php');
require_once(__DIR__ . '/operator/Delete.php');
require_once(__DIR__ . '/operator/Update.php');


class DB {

    protected $table;

    private function __construct($table) {
        $this->table = $table;
    }

    public static function table($table) {
        return new DB($table);
    }

    public static function connect() {
        // Turning constants into local variables
        $user = DB_USER;
        $psw = DB_PSW;
        $host = DB_HOST;
        $db = DB_NAME;
        // Creating the PDO
        $dbh = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $psw);
        // Ignoring types of data
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $dbh;
    }

    public function select(array $columns) {
        return Select::from($this->table, $columns);
    }

    public function insert(array $columns) {
        return Insert::into($this->table, $columns);
    }

    /**
     * @param array $columns
     * @return Update
     */
    public function update(array $columns) {
        return Update::table($this->table)->set($columns);
    }

    public function delete() {
        return Delete::from($this->table);
    }
}