<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\DeleteUser;

class ModerController extends Controller
{
    public function login(Request $req)
    {
        $email = $req->get('email');
        $password = $req->get('password');
        $user = User::where([
            ['email', '=', $email],
            ['password', '=', $password]
        ])->first();

        if ($user === null)
            return $this->error('Неверный логин или пароль', '1002');

        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json(['access_token' => $token], 200);
    }

    public function addBook(Request $req)
    {
    }

    public function deleteBook(Request $req)
    {
    }

    public function deleteUser(Request $req)
    {
        $user_id = $req->get('user_id');
        $moder_id = Auth::id();
        $deleted_at = date("Y-m-d");
        DeleteUser::crete(
            [
                'user_id' => $user_id,
                'moder_id' => $moder_id,
                'deleted_at' => $deleted_at
            ]
        );
    }

    public function unDeleteUser(Request $req)
    {
    }
}
