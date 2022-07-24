<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\UserBook;

class LibrarianController extends Controller
{
    public function addBook(Request $req)
    {
        if (Auth::user()->role != 'librarian')
            return $this->message('Non Authorize', 1001);

        $req->validate([
            'name'=>'required|alpha_num',
            'author'=>'required|alpha',
            'description'=>'required',
            'genre'=>'required|alpha',
            'year'=>'required|digits:4'
        ]);

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
        return $this->message('Ok', 200);
    }

    public function deleteBook(Request $req)
    {
        if (Auth::user()->role != 'librarian')
            return $this->message('Non Authorize', 1001);

        $req->validate([
            'book_id' => 'required|numeric'
        ]);

        $book_id = $req->get('book_id');
        Book::find($book_id)->delete();
        return $this->message('Ok', 200);
    }

    // public function sendBook(Request $req)
    // {
    //     $librarian_id = Auth::id();
    //     $user_book_id = $req->get('user_book_id');
    //     UserBook::where('id', '=', $user_book_id)->update(['librarian_id' => $librarian_id]);
    //     return $this->message('Ok',200);
    // }

    // public function receiveBook(Request $req)
    // {
    //     $book_id = $req->get('book_id');
    //     UserBook::where(
    //         'book_id',
    //         '=',
    //         $book_id
    //     )->delete();
    //     return $this->message('Ok',200);
    // }
}
