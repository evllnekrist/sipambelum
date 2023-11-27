<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;
use App\Models\Trainee;

class Trainee_Training extends Model
{
    // use SoftDeletes;

    protected $table = 'map_trainee_training';
    protected $fillable = [
        'id_training',
        'id_local_potential',
        'level',
        'id_trainee',
        'active',
        'is_passed',
        'mark',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class,'id_trainee','id');
    }
}