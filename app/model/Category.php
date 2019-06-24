<?php

namespace App\Model;

require_once 'Model.php';

class Category extends Model {

    public $table = 'categories';

    public $id;
    public $name;
    public $icon;

    public $fillable = ['name', 'icon'];

}