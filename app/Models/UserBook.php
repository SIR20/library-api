<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'user_book';
    protected $fillable = [
        'id',
        'user_id',
        'book_id',
        'librarian_id',
        'reservated_at'
    ];
}
