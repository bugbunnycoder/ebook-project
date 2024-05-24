<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'author',
        'front_cover',
        'back_cover',
        'file_path',
        'front_title',
        'front_description',
        'back_title',
        'back_description',
        'author_image',
        'paragraph'
    ];
}
