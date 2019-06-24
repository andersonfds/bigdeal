<?php

namespace App\Controller;


require_once __DIR__ . '/../model/Favorite.php';
require_once __DIR__ . '/../model/Photo.php';

use App\Model\Favorite;
use System\Request;

class FavoriteController extends Controller {

    public function index(Request $request) {
        $anuncios = $request->get_user()->getFavorites();
        view('index', compact('anuncios'));
    }

    public function store(Request $request) {
        // Creating a new favorite
        $favorite = new Favorite();
        // Filling with the data
        $favorite->user = $request->get_user()->id;
        $favorite->anuncio = $request->get_args()[0];
        // Returning whether was saved or not
        return ['status' => $favorite->save()];
    }

    public function status(Request $request) {
        // Getting the advertisement id
        $anuncio = $request->get_args()[0];
        // Checking if its already on the database
        return ['status' => $request->get_user()->getFavorites($anuncio)];
    }

    public function destroy(Request $request) {
        // Creating an instance and setting the values
        $favorite = new Favorite();
        $favorite->user = $request->get_user()->id;
        $favorite->anuncio = $request->get_args()[0];
        // Executing the delete and returning boolean
        return ['status' => $favorite->remove()];
    }

}