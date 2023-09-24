<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Training extends Model
{
    use SoftDeletes;

    protected $table = 'tr_training';
    protected $fillable = [
        'level',
        'trainee_limit',
        'name',
        'desc',
        'img_main',
        'file_main',
        'address',
        'contact_phone',
        'contact_email',
        'event_start',
        'event_end',
    ];
}