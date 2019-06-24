<?php


namespace App\Controller;

require_once __DIR__ . '/../model/Anuncio.php';
require_once __DIR__ . '/../model/Photo.php';

use App\Model\Anuncio;

class SearchController extends Controller {


    public function search() {
        $term = filter_input(INPUT_GET, 'q');
        $anuncios = Anuncio::search($term);
        view('index', compact('anuncios'));
    }

}