<?php

namespace App\Models;
use App\Models\CRUD;

// chanson_genre
class Style extends CRUD {
    protected $table = 'style';
    protected $primaryKey = 'id';
    protected $fillable = ['chanson_id', 'genre_id'];
}