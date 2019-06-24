<?php

namespace System;

use App\CRUD\DB;
use App\CRUD\Select;
use App\Model\Anuncio;
use App\Model\Photo;

class Storage {

    private static $max_per_request = 4;
    private static $max_size = 500000;
    private static $upload_dir = __DIR__ . "/../public/photos/";
    private static $allowed = [
        // Allowed formats should be the index
        'jpg' => true, 'png' => true, 'jpeg' => true
    ];

    public static function upload($param_name) {
        $file = $_FILES[$param_name];
        // This array holds all the file names
        $output = array();
        // Checking if are multiple files to upload
        if (is_array($file['name']))
            // Limiting the max number of images
            if (sizeof($file['name']) <= self::$max_per_request)
                // Uploading all files
                $output = self::upload_all($file);
        // Returning the output variable
        return $output;
    }

    private static function upload_all($file) {
        $output = array();
        for ($i = 0; $i < sizeof($file['name']); $i++) {
            // Getting the values
            $tmp_name = $file['tmp_name'][$i];
            $size = $file['size'][$i];
            $name = self::gen_name($file['name'][$i]);
            // Checking if the format is allowed into the system
            if (isset(self::$allowed[self::get_format($name)]))
                // Checking if even being the valid format if is an image
                if (self::validate_image($tmp_name, $size))
                    $output[] = self::save($tmp_name, $name);
        }
        return $output;
    }

    private static function gen_name($file) {
        // unique id + dot + format equals to:  x.jpg
        return uniqid() . '.' . self::get_format($file);
    }

    private static function get_format($file) {
        // Getting the format of the file
        return pathinfo($file, PATHINFO_EXTENSION);
    }


    private static function validate_image($tmp_name, $size) {
        // Returning if the image size is smaller than 500KB
        if ($size > self::$max_size) return false;
        // Checking if the image is a square, smaller than 1024 pixels
        return (($size = getimagesize($tmp_name)) && $size[0] == $size[1] && $size[0] <= 1024);
    }

    private static function save($tmp_name, $perm_name) {
        // Getting the final file name
        $full_dir = self::$upload_dir . $perm_name;
        // If file does not exists (should exists be true)
        if (!file_exists($full_dir)) {
            // Moving to the right path to save it
            move_uploaded_file($tmp_name, $full_dir);
            // Returning the name of the file
            return $perm_name;
        } else return false;
    }

    public static function delete(Anuncio $anuncio) {
        // Finding the files from the database
        $SQL = Select::from('photos', Select::ALL);
        $SQL->where('anuncio = ?');
        $con = DB::connect()->prepare($SQL->build());
        $con->execute([$anuncio->id]);
        // Getting the goods
        $data = $con->fetchAll(\PDO::FETCH_ASSOC);
        // Removing all the photos from the database and physically
        foreach ($data as $photo) self::remove($photo);
    }

    private static function remove($photo) {
        // Getting the file name
        $file = self::$upload_dir . $photo['name'];
        // Deleting from the database
        (new Photo($photo['id']))->remove();
        // Deleting from the server
        if (file_exists($file)) unlink($file);
    }

}