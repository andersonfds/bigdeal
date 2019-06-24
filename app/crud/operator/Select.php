<?php

namespace App\CRUD;


class Select {

    const ALL = ['*'];

    const TYPE_INNER = 'INNER';
    const TYPE_LEFT = 'LEFT';
    const TYPE_RIGHT = 'RIGHT';

    private $query = [];

    private function __construct($table, array $columns) {
        $this->query[0] = "SELECT " . implode(',', $columns) . " FROM {$table}";
        return $this;
    }

    public static function from($table, array $columns) {
        return new Select($table, $columns);
    }

    public function join($table, $condition, $type = self::TYPE_INNER) {
        $this->query[1] = "{$type} JOIN {$table} ON {$condition}";
        return $this;
    }

    public function where($condition) {
        $this->query[2] = "WHERE {$condition}";
        return $this;
    }

    public function group($columns, $condition) {
        $this->query[3] = "GROUP BY {$columns} HAVING {$condition}";
        return $this;
    }

    public function order($columns) {
        $this->query[4] = "ORDER BY {$columns}";
        return $this;
    }

    public function limit($max, $offset = 0) {
        $this->query[5] = "LIMIT {$max} OFFSET {$offset}";
        return $this;
    }

    public function build() {
        // Sorting by key
        ksort($this->query);
        // Returning
        return implode(" ", $this->query);
    }

}