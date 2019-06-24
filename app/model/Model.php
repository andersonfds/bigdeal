<?php

namespace App\Model;

use App\CRUD\DB;
use PDO;

require_once __DIR__ . '/../crud/DB.php';

class Model
{

    public $id;
    public $table;
    public $fillable = [];

    private $ignore = [
        'ignore', 'id', 'table', 'fillable'
    ];

    public function __construct($id = null)
    {
        if ($id) $this->id = $id;
        return $this;
    }

    public static function is_favorite($user, $anuncio)
    {
        // Building the Select Query
        $SQL = DB::table('favorites')->select(['*']);
        $SQL->where('user = ? AND anuncio = ?')->limit(1);
        // Running the SQL and fetching the result
        $db = DB::connect()->prepare($SQL->build());
        $db->execute([$user, $anuncio]);
        return $db->rowCount() > 0;
    }

    /**
     * @param $id
     * @return $this|bool
     */
    public static function find($id)
    {
        if ($obj = self::instance()) {
            $SQL = DB::table($obj->table)->select(['*'])->where('id = ?');
            $con = DB::connect()->prepare($SQL->build());
            $con->execute([$id]);
            // Returning in case it wasn't found
            if (!$con->rowCount()) return false;
            // Filling all data into the object and returning
            return $obj->fillAll($con->fetch(\PDO::FETCH_ASSOC));
        } else return false;
    }

    public static function instance()
    {
        $c = get_called_class();
        // Creating a new instance of the class
        $obj = new $c();
        // Returning if it inherits Model
        return $obj instanceof Model ? $obj : false;
    }

    /**
     * @param $data
     * @return $this
     */
    public function fillAll($data)
    {
        // Foreach existing field
        foreach ($data as $key => $value) {
            if (property_exists($this, $key))
                // Replacing the current value
                $this->$key = $value;
        }
        // Returning the object
        return $this;
    }

    public static function paginate($max, $page, $hide = 0)
    {
        // Checking if $page is numeric or it should be 0
        if (!is_numeric($page)) $page = 0;
        // Creating the query
        $columns = self::instance()->fillable;
        $columns[] = 'id';
        $SQL = DB::table(self::instance()->table)->select($columns)->where('id != ?');
        $SQL->limit('?', '?');
        $SQL->order('id DESC');
        // Searching on database
        $con = DB::connect()->prepare($SQL->build());
        $con->execute([$hide, $max, $page * $max]);
        // Returning the array
        return $con->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fill($data)
    {
        // Foreach fillable field
        foreach ($this->fillable as $canFill) {
            if (isset($data[$canFill]))
                // Filling with the provided array
                $this->$canFill = $data[$canFill];
        }
        // Returning this
        return $this;
    }

    public function save()
    {
        // If the id exists, it means that we should update
        if (!empty($this->id)) return $this->update();
        // Otherwise it should be inserted
        else return $this->insert();
    }

    private function update()
    {
        // Getting the columns and values
        $data = $this->getColumns();
        $columns = array_keys($data);
        $values = array_values($data);
        // Appending the id into the values
        $values[] = $this->id;
        // Building the Update statement
        $SQL = DB::table($this->table)->update($columns);
        $SQL->where('id = ?')->limit(1);
        // Running the script and returning the rows
        $con = DB::connect()->prepare($SQL->build());
        $con->execute($values);
        return $con->rowCount() > 0;
    }

    public function getColumns()
    {
        // Gets all the variables on the class
        $vars = get_object_vars($this);
        // Deleting unwanted fields on the request
        foreach ($this->ignore as $ignored) {
            if (isset($vars[$ignored]))
                unset($vars[$ignored]);
        }
        // Returning the variable
        return $vars;
    }

    private function insert()
    {
        // Getting the columns and values
        $data = $this->getColumns();
        $columns = array_keys($data);
        $values = array_values($data);
        // Building the Update statement
        $SQL = DB::table($this->table)->insert($columns);
        // Running the script and returning the rows
        $pdo = DB::connect();
        $con = $pdo->prepare($SQL->build());
        $con->execute($values);
        $this->id = $pdo->lastInsertId();
        return $con->rowCount() > 0;
    }

    public function remove()
    {
        // Building the delete query
        $SQL = DB::table($this->table)->delete()->where('id = ?')->limit(1);
        // Executing and returning if it was deleted
        $con = DB::connect()->prepare($SQL->build());
        $con->execute([$this->id]);
        return $con->rowCount() > 0;
    }

}