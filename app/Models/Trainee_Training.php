<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Trainee_Training extends Model
{
    use SoftDeletes;

    protected $table = 'map_trainee_training';
    protected $fillable = [
        'id_training',
        'id_trainee',
        'active',
        'is_passed',
        'mark',
    ];
}