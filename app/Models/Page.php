<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Page extends Model
{
    use SoftDeletes;

    protected $table = 'ms_page';
    protected $fillable = [
      'img_main',
      'title',
      'body',
      'slug',
      'created_at',
      'created_by',
      'updated_at',
      'updated_by',
    ];
}
