<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Config extends Model
{
    use SoftDeletes;

    protected $table = 'ms_config';
     // Define the primary key
    protected $fillable = [
        'code',
        'value',
        'label',
        'img_main',
        'url_link',
    ];
}