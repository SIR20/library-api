<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function getBooks()
    {
        return response()->json(Book::all());
    }

    public function getBookByName(Request $req)
    {

        $req->validate([
            'name'=>'required|alpha',
        ]);

        $name = $req->get('name');
        return response()->json(Book::where('name', '=', $name));
    }

    public function getBookByGenre(Request $req)
    {
        $req->validate([
            'genre'=>'required|alpha',
        ]);

        $genre = $req->get('genre');
        return response()->json(Book::where('genre', '=', $genre));
    }

    public function getBookByAuthor(Request $req)
    {
        $req->validate([
            'author'=>'required|alpha',
        ]);

        $author = $req->get('author');
        echo $author;
        $result = Book::where('author', $author);
        return response()->json($result);
    }
}
