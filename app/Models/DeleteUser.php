<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'moder_id',
        'deleted_at'
    ];
}
