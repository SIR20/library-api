<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create(Request $req)
    {
        $name = $req->get('name');
        $email = $req->get('email');
        $password = $req->get('password');
        $created_at = date("Y-m-d");
        if (User::where('email', '=', $email)->first() != null)
            return $this->error('Пользователь с таким логином уже существует','1001');

        $user = User::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => 'user',
                'created_at' => $created_at
            ]
        );
        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json(['access_token' => $token], 200);
    }

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

    public function rename(Request $req)
    {
        return response(Auth::user()->role, 200);
    }

    public function changePassword(){

    }

    public function changeEmail(){
        
    }
}
