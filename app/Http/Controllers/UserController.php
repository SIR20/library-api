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
            return $this->message('Пользователь с таким логином уже существует', '1001');

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
            return $this->message('Неверный логин или пароль', '1002');

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
        echo $author;
        $result = Book::where('author', $author);
        return response()->json($result);
    }

    public function reservation(Request $req)
    {
        $user_id = Auth::id();
        $book_id = $req->get('book_id');
        $reservated_at = date("Y-m-d");
        UserBook::create(['book_id' => $book_id, 'user_id' => $user_id, 'librarian_id' => 0, 'reservated_at' => $reservated_at]);
        return $this->message('Ok',200);
    }

    public function canselReservation(Request $req)
    {
        $user_id = Auth::id();
        $book_id = $req->get('book_id');
        UserBook::where([
            ['book_id', '=', $book_id],
            ['user_id', '=', $user_id]
        ])->delete();
        return $this->message('Ok',200);
    }
}
