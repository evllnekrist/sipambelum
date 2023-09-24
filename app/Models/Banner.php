<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Banner extends Model
{
    use SoftDeletes;

    protected $table = 'tr_banner';
    protected $fillable = [
      'name',
      'img_main',
      'title',
      'subtitle',
      'sequence',
      'url_link',
      'button_link',
      'button_title',
      'publish_start',
      'publish_end',
      'created_at',
      'created_by',
      'updated_at',
      'updated_by',
    ];
}
