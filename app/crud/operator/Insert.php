<?php

namespace App\CRUD;

class Insert {

    private $query = [];

    private function __construct($table, array $columns) {
        $column = '`' . implode('`,`', $columns) . '`';
        $values = $this->make_mark(sizeof($columns));

        $this->query[0] = "INSERT INTO {$table}($column) VALUES($values)";
        return $this;
    }

    private function make_mark($size) {
        $output = '';
        while ($size-- > 0) {
            $output .= $size > 0 ? '?, ' : '?';
        }
        return $output;
    }

    public static function into($table, array $columns) {
        return new Insert($table, $columns);
    }

    public function build() {
        return implode(" ", $this->query);
    }
}