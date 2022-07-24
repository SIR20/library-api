<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create(Request $req)
    {

        $req->validate([
            'name' => 'required|alpha',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $name = $req->get('name');
        $email = $req->get('email');
        $password = $req->get('password');
        $created_at = date("Y-m-d");

        if (User::where('email', '=', $email)->first() != null)
            return $this->message('Пользователь с таким логином уже существует', 1001);

        $user = User::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => 'user',
                'created_at' => $created_at
            ]
        );

        $token = $user->createToken('API Token', [$user->role])->plainTextToken;
        return response()->json(['access_token' => $token], 200);
    }

    public function login(Request $req)
    {

        $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $email = $req->get('email');
        $password = $req->get('password');
        $user = User::where('email', '=', $email)->first();

        if (!Hash::check($password, $user->password))
            return $this->message('Неверный логин или пароль', 1001);


        $token = $user->createToken('API Token', [$user->role])->plainTextToken;
        return response()->json(['access_token' => $token], 200);
    }
}
