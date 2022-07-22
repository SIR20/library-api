<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\UserBook;

class LibrarianController extends Controller
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

        if ($user->role === 'librarian') {
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json(['access_token' => $token], 200);
        }
    }

    public function addBook(Request $req)
    {
        $name = $req->get('name');
        $author = $req->get('author');
        $description = $req->get('description');
        $genre = $req->get('genre');
        $year = $req->get('year');
        Book::create(
            [
                'name' => $name,
                'author' => $author,
                'description' => $description,
                'genre' => $genre,
                'year' => $year
            ]
        );
    }

    public function deleteBook(Request $req)
    {
        $book_id = $req->get('book_id');
        Book::find($book_id)->delete();
    }

    public function sendBook(Request $req)
    {
        $librarian_id = Auth::id();
        $user_book_id = $req->get('user_book_id');
        UserBook::where('id','=',$user_book_id)->update(['librarian_id' => $librarian_id]);
    }

    public function receiveBook(Request $req)
    {
    }
}
