<?php

namespace App\Model;

use App\CRUD\DB;

require_once 'Model.php';

class Favorite extends Model
{

    public $table = 'favorites';

    public $id;
    public $user;
    public $anuncio;

    public function remove()
    {
        // Building the delete query
        $SQL = DB::table($this->table)->delete()->where('anuncio = ? AND user = ?');
        // Safety in first place
        $SQL->limit(1);
        // Executing and returning if it was deleted
        $con = DB::connect()->prepare($SQL->build());
        $con->execute([$this->anuncio, $this->user]);
        return $con->rowCount() > 0;
    }

    public function save()
    {
        // Getting the columns and values dynamically
        $data = $this->getColumns();
        $columns = array_keys($data);
        $values = array_values($data);
        // Checking if it is already saved as favorite
        if (!self::is_favorite($this->user, $this->anuncio)) {
            $SQL = DB::table($this->table)->insert($columns);
            $con = DB::connect()->prepare($SQL->build());
            $con->execute($values);
            return $con->rowCount() > 0;
        } else return true;
    }

    public static function deleteAll(User $u)
    {
        $SQL = DB::table(self::instance()->table)->select(['*'])->where('user = ?');
        $con = DB::connect()->prepare($SQL->build());
        $con->execute([$u->id]);
        foreach ($con->fetchAll(\PDO::FETCH_ASSOC) as $favorite) {
            $instance = (new Favorite($favorite['id']))->fillAll($favorite);
            $instance->remove();
        }
    }

}