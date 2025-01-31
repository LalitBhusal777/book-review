<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'book_id',  // ✅ Add this line
        'user_id',
        'review',
        'rating',
        ];
}
