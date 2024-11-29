<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'cover_url',
        'user_id',
        'is_read',
        'is_favourite',
        'is_owned',
        'authors',
        'tags',
        'page_count'
    ];
}
