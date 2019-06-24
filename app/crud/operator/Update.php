<?php

namespace App\CRUD;

class Update {

    private $query = [];

    private function __construct($table) {
        $this->query[0] = "UPDATE {$table}";
    }

    public static function table($table) {
        return new Update($table);
    }

    public function set(array $columns) {
        $value = [];
        foreach ($columns as $column) {
            $value[] = "`{$column}` = ?";
        }
        $value = implode(', ', $value);
        $this->query[1] = "SET {$value}";
        return $this;
    }

    public function where($condition) {
        $this->query[2] = "WHERE {$condition}";
        return $this;
    }

    public function limit($max) {
        $this->query[3] = "LIMIT {$max}";
        return $this;
    }

    public function build() {
        return implode(" ", $this->query);
    }

}