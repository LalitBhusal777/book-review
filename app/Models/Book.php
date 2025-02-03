<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $table = 'books';
    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
