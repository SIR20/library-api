<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
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

        if ($user->role === 'admin') {
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json(['access_token' => $token], 200);
        }
    }

    public function addUser(Request $req)
    {
        $name = $req->get('name');
        $email = $req->get('email');
        $password = $req->get('password');
        $role = $req->get('role');
        $created_at = date("Y-m-d");
        if (User::where('email', '=', $email)->first() != null)
            return $this->message('Пользователь с таким логином уже существует', '1001');

        $user = User::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'created_at' => $created_at
            ]
        );
        return $this->message('Ok',200);
    }

    public function deleteUser(Request $req)
    {
        $user_id = $req->get('user_id');
        User::find($user_id)->delete();
        return $this->message('Ok',200);
    }

    public function setPassword(Request $req)
    {
        $user_id = $req->get('user_id');
        $password = $req->get('password');
        User::find($user_id)->update(['password' => $password]);
        return $this->message('Ok',200);
    }
}
