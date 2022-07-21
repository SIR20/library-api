<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
}
