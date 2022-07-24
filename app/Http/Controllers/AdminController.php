<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function addUser(Request $req)
    {
        if (Auth::user()->role != 'admin')
            return $this->message('Non Authorize', 1001);

        $req->validate([
            'name|required|alpha',
            'email|required|email',
            'password|required',
            'role|required|alpha',
        ]);

        $name = $req->get('name');
        $email = $req->get('email');
        $password = $req->get('password');
        $role = $req->get('role');
        $created_at = date("Y-m-d");

        if (User::where('email', '=', $email)->first() != null)
            return $this->message('Пользователь с таким логином уже существует', 1001);

        User::create(
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'created_at' => $created_at
            ]
        );
        return $this->message('Ok', 200);
    }

    public function deleteUser(Request $req)
    {
        if (Auth::user()->role != 'admin')
            return $this->message('Non Authorize', 1001);

        $req->validate([
            'user_id|required|numeric'
        ]);

        $user_id = $req->get('user_id');
        User::find($user_id)->delete();
        return $this->message('Ok', 200);
    }

    public function setPassword(Request $req)
    {
        if (Auth::user()->role != 'admin')
            return $this->message('Non Authorize', 1001);

        $req->validate([
            'user_id|required|numeric',
            'password|required'
        ]);

        $user_id = $req->get('user_id');
        $password = $req->get('password');
        User::find($user_id)->update(['password' => $password]);
        return $this->message('Ok', 200);
    }
}
