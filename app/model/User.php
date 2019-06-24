<?php

namespace App\Model;

use App\CRUD\DB;

require_once 'Model.php';
require_once 'Anuncio.php';

class User extends Model {

    public $table = 'users';

    public $id;
    public $email;
    public $password;
    public $name;
    public $city;
    public $state;
    public $phone;
    public $level;

    public $fillable = [
        'email', 'password', 'name', 'city', 'state', 'phone', 'level'
    ];

    public function getAnuncios() {
        // Building the Select query
        $SQL = DB::table('anuncios')->select(['*'])->where('author = ?');
        // Running the select
        $con = DB::connect()->prepare($SQL->build());
        $con->execute([$this->id]);
        // Returning the advertisements formatted
        $anuncios = $con->fetchAll(\PDO::FETCH_ASSOC);
        return Anuncio::formatted($anuncios);
    }

    public function getFavorites($id = null) {
        // Building the select query
        $SQL = DB::table('favorites f')->select(['*'])->where('f.user = ?');
        $SQL->join('anuncios a', 'f.anuncio = a.id')->order('f.id DESC');
        // If the advertisement is not null should get it
        if (!empty($id) && is_numeric($id)) {
            $SQL->where('f.user = ? AND a.id = ?');
            $values[] = $id;
        } else $values[] = $this->id;
        // Running the script
        $con = DB::connect()->prepare($SQL->build());
        $con->execute($values);
        // Returning the advertisements formatted
        $anuncios = $con->fetchAll(\PDO::FETCH_ASSOC);
        return Anuncio::formatted($anuncios);
    }
}