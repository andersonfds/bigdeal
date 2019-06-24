<?php

namespace App\CRUD;

class Delete {

    private $query = [];

    private function __construct() {
        $this->query[0] = "DELETE";
    }

    public static function from($table) {
        $delete = new Delete();
        $delete->query[1] = "FROM {$table}";
        return $delete;
    }

    public function where($condition) {
        $this->query[2] = "WHERE {$condition}";
        return $this;
    }

    public function limit($limit) {
        $this->query[3] = "LIMIT {$limit}";
        return $this;
    }

    public function build() {
        return implode(" ", $this->query);
    }

}