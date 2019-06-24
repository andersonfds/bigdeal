<?php

namespace App\Model;

use App\CRUD\DB;

require_once 'Model.php';
require_once 'Photo.php';

/**
 * @property array photo
 * @property int is_favorite
 */
class Anuncio extends Model
{

    public $table = 'anuncios';

    public $id;
    public $title;
    public $description;
    public $price;
    public $created_at;
    public $author;
    public $category;
    public $views;
    public $is_used;

    public $fillable = [
        'title', 'description', 'price', 'category', 'is_used'
    ];

    public static function find($id)
    {
        if ($anuncio = parent::find($id)) {
            if ($anuncio instanceof Anuncio) {
                // Checking if is the author viewing
                if ($anuncio->author == get_user_id()) return $anuncio;
                // If is not it will add one into the view counter
                $anuncio->views++;
                $anuncio->save();
            }
        }
        // Returning the standard output
        return $anuncio;
    }

    public static function paginate($max, $page, $hide = 0)
    {
        if ($output = parent::paginate($max, $page, $hide))
            return self::formatted($output);
        return $output;
    }

    public static function formatted($output)
    {
        foreach ($output as $key => $value) {
            // Setting the photo name
            $output[$key]['photo'] = self::photo_url(Photo::photos($value['id'], 1));
            $output[$key]['price'] = 'R$' . number_format($value['price'], 2, '.', ',');
        }
        return $output;
    }

    private static function photo_url($photo)
    {
        // If image does not exists shows the default image
        if (empty($photo)) return route('images/default.jpg', false);
        // Formatting the url of the first image
        $photo = $photo[0]['name'];
        return route("photos/${photo}", false);
    }

    public static function search($term)
    {
        $SQL = DB::table(self::instance()->table)->select(['*']);
        $SQL->where('title LIKE ? or description LIKE ?');

        $db = DB::connect()->prepare($SQL->build());
        $term = "%${term}%";
        $db->execute([$term, $term]);
        return self::formatted($db->fetchAll(\PDO::FETCH_ASSOC));
    }

    public static function deleteAll(User $user)
    {
        foreach ($user->getAnuncios() as $anuncio) {
            // Deleting all uploaded photos
            Photo::deleteAll($anuncio['id']);
            // Deleting the entry from database
            (new Anuncio($anuncio['id']))->remove();
        }
    }

}