<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'title',
        'content',
        'status',
        'keywords',
        'img_main',
        'caption',
        'author',
        'img_author',
        'sequence',
        'publish_at'
    ];
    protected $table = 'tr_news';
    public $timestamps = false;
}