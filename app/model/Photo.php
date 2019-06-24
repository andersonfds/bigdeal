<?php

namespace App\Model;

use App\CRUD\DB;

class Photo extends Model
{

    public $table = 'photos';

    public $id;
    public $name;
    public $anuncio;


    public static function photos($anuncio_id, $limit = 4)
    {
        // Building the Select Query
        $SQL = DB::table(self::instance()->table)->select(['*']);
        $SQL->where('anuncio = ?');
        $SQL->limit('?');
        // Instantiating and executing the query
        $con = DB::connect()->prepare($SQL->build());
        $con->execute([$anuncio_id, $limit]);
        // Otherwise it will return all the found fields
        return $con->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function deleteAll($anuncio)
    {
        $photos = self::photos($anuncio);
        foreach ($photos as $photo) {
            // Deleting the actual file from the folder
            $file = __DIR__ . '/../../public/photos/' . $photo['name'];
            if (file_exists($file))
                unlink(__DIR__ . '/../../public/photos/' . $photo['name']);
            // Deleting from the database
            (new Photo($photo['id']))->remove();
        }
    }

}