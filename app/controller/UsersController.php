<?php

namespace App\Controller;

use App\Model\Anuncio;
use App\Model\Favorite;
use App\Model\User;
use System\Request;


require_once(__DIR__ . '/../model/Favorite.php');

class UsersController extends Controller
{

    public function manage(Request $request)
    {
        $page = filter_input(INPUT_GET, 'page');
        $users = User::paginate(60, $page, $request->get_user()->id);
        view('users.list', compact('users'));
    }

    public function levelUp(Request $request)
    {
        if ($user = User::find($request->get_args()[0])) {
            if ($user->id !== $request->get_user()->id) {
                if ($user->level < 9) {
                    $user->level += 1;
                    $user->save();
                }
            }
            redirect('users/manage');
        }
    }

    public function levelDown(Request $request)
    {
        if ($user = User::find($request->get_args()[0])) {
            if ($user->id !== $request->get_user()->id) {
                if ($user->level > 1) {
                    $user->level -= 1;
                    $user->save();
                }
            }
            redirect('users/manage');
        }
    }

    public function destroy(Request $request)
    {
        if ($user = User::find($request->get_args()[0])) {
            if ($user->id !== $request->get_user()->id) {
                // Removing the user's favorites
                Favorite::deleteAll($user);
                // Removing all user's advertisement
                Anuncio::deleteAll($user);
                // Removing the user
                $user->remove();
                redirect('users/manage');
            }
        }
    }
}