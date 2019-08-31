<?php

namespace App\Controller;

require_once(__DIR__ . '/../model/Anuncio.php');
require_once(__DIR__ . '/../model/Category.php');
require_once(__DIR__ . '/../model/Photo.php');

use App\Model\Anuncio;
use App\Model\Category;
use App\Model\Photo;
use App\Model\User;
use System\Request;
use System\Storage;

class AnuncioController extends Controller {

    public function index() {
        $page = filter_input(INPUT_GET, 'page');
        $anuncios = Anuncio::paginate(60, $page);
        // Showing the advertisement view
        view('index', compact('anuncios'));
    }

    public function create() {
        $categories = $this->getAllCategories();
        view('anuncio.edit', compact('categories'));
    }

    public function store(Request $request) {
        // Creating a new instance
        $ad = new Anuncio();
        $ad->fill($request->all());
        // Getting the author id
        $ad->author = $request->get_user()->id;
        // Formatting the price
        $ad->price = number_format($ad->price, 2);
        // Inserting into the database
        $ad->save();
        // Uploading all  the photos and saving into the database
        $this->upload_all_photos($ad, 'photo');
        // Redirecting to the ad user list route
        redirect('anuncio/list');
    }

    public function upload_all_photos(Anuncio $ad, $param) {
        // Getting all the uploaded photos
        $photos = Storage::upload($param);
        // Saving into the database
        foreach ($photos as $photo) {
            // Creating a Photo
            $p = new Photo();
            // Setting the values
            $p->name = $photo;
            $p->anuncio = $ad->id;
            // Inserting into the database
            $p->save();
        }
    }

    public function show(Request $request) {
        // Getting the requested advertisement via id
        if (($anuncio = Anuncio::find($request->get_args()[0]))) {
            // Getting extra information such as author name etc.
            $anuncio = $this->get_extra_info($anuncio);
            // Setting if it is favorite
            if ($request->get_user() != null) {
                $anuncio->is_favorite = User::is_favorite($request->get_user()->id, $anuncio->id);
            }
            // Showing the view and sending the variable
            view('anuncio.view', ['anuncio' => $this->formatted($anuncio)]);
        } else abort(404);
    }

    private function get_extra_info(Anuncio $a) {
        // Finding and setting the author
        $a->author = User::find($a->author);
        // Finding and setting the category
        $a->category = Category::find($a->category);
        // Setting the photos
        $a->photo = Photo::photos($a->id, 4);
        // Returning back the user
        return $a;
    }

    private function formatted(Anuncio $a) {
        // Formatting the number to money
        $a->price = 'R$' . number_format($a->price, 2, '.', ',');
        // Formatting to get the first name
        $a->author->name = explode(' ', $a->author->name)[0];
        // Formatting the used variable to hold string
        $a->is_used = $a->is_used ? "Usado" : "Novo";
        // Formatting the date
        $a->created_at = date('d/m/Y', strtotime($a->created_at));
        return $a;
    }

    public function edit(Request $request) {
        // Checking if the advertisement actually exists
        if ($anuncio = Anuncio::find($request->get_args()[0])) {
            if ($anuncio->author == $request->get_user()->id) {
                // Getting all the categories available
                $categories = $this->getAllCategories();
                // Showing the advertisement view
                $photos = Photo::photos($anuncio->id, 4);
                view('anuncio.edit', compact('anuncio', 'categories', 'photos'));
            } else abort(404);
        } else abort(404);
    }

    private function getAllCategories() {
        $categories = Category::paginate(500, 0);
        // If there is no categories, then create one
        if (empty($categories)) {
            $cat = new Category();
            $cat->name = 'Outro';
            $cat->icon = 'fas fa-boxes';
            $cat->save();
            $categories = Category::paginate(500, 0);
        }
        return $categories;
    }

    public function update(Request $request) {
        // Finding the requested advertisement
        $anuncio = Anuncio::find($request->get_args()[0]);
        // Checking if the user editing is the actual author
        if ($anuncio !== false && $anuncio->author == $request->get_user()->id) {
            // Filling the data with the provided info
            $anuncio->fill($request->all());
            // Checking if there is a photo to replace
            if (isset($_FILES['photo']) && !$_FILES['photo']['error'][0]) {
                // Deleting existing files
                Storage::delete($anuncio);
                // Uploading the new ones
                $this->upload_all_photos($anuncio, 'photo');
            }
            // Saving into the database
            $anuncio->save();
            // Redirecting to the edit route
            redirect("anuncio/{$anuncio->id}/edit");
        } else abort(404);
    }

    public function destroy(Request $request) {
        // Getting the advertisement
        $anuncio = Anuncio::find($request->get_args()[0]);
        // Checking the current user is the author
        if ($anuncio !== false && $anuncio->author == $request->get_user()->id) {
            // Deleting existing photos
            Storage::delete($anuncio);
            // Permanently deleting the entry
            $anuncio->remove();
            // Redirecting back
            redirect('anuncio/list');
        } else abort(404);
    }

    public function userList(Request $request) {
        // Getting the current user advertisements
        $anuncios = $request->get_user()->getAnuncios();
        view('anuncio.list', compact('anuncios'));
    }
}