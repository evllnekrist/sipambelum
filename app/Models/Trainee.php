<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Trainee extends Model
{
    use SoftDeletes;

    protected $table = 'ms_trainee';
    protected $fillable = [
        'level',
        'nik',
        'name',
        'sex',
        'religion',
        'place_of_birth',
        'date_of_birth',
        'latest_edu',
        'phone',
        'email',
        'subdistrict_of_residence',
    ];
}