<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\UserBook;

class UserController extends Controller
{
    public function create(Request $req)
    {
        $name = $req->get('name');
        $email = $req->get('email');
        $password = $req->get('password');
        $created_at = date("Y-m-d");
        if (User::where('email', '=', $email)->first() != null)
            return $this->error('Пользователь с таким логином уже существует', '1001');

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

        if ($user->role === 'user') {
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json(['access_token' => $token], 200);
        }
    }

    public function getBooks()
    {
        return response()->json(Book::all());
    }

    public function getBookByName(Request $req)
    {
        $name = $req->get('name');
        return response()->json(Book::where('name', '=', $name));
    }

    public function getBookByGenre(Request $req)
    {
        $genre = $req->get('genre');
        return response()->json(Book::where('genre', '=', $genre));
    }

    public function getBookByAuthor(Request $req)
    {
        $author = $req->get('author');
        return response()->json(Book::where('author', '=', $author));
    }

    public function reservation(Request $req)
    {
        
    }

    public function canselReservation(Request $req)
    {
    }
}
