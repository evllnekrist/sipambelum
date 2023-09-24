<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Training_LocalPotential extends Model
{
    use SoftDeletes;

    protected $table = 'map_training_local_potential';
    protected $fillable = [
        'id_training',
        'id_local_potential',
    ];
}