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

        $token = $user->createToken('API Token')->plainTextToken;
        return response()->json(['access_token' => $token], 200);
    }

    public function addModer(Request $req){

    }

    public function deleteModer(Request $req){

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
