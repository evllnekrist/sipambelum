<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Trainee_Business extends Model
{
    use SoftDeletes;

    protected $table = 'map_trainee_business';
    protected $fillable = [
        'id_business',
        'id_trainee',
        'active',
        'job_title',
    ];
}