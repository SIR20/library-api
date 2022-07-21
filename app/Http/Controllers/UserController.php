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

        $user = User::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'created_at' => $created_at
            ]
        );



        return response()->json($user->createToken('API Token'), 200);
    }

    public function login(Request $req)
    {
        return response('Ok', 200);
    }

    public function rename(Request $req)
    {
        return response('OK', 200);
    }
}
