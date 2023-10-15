<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Trainee_Training;

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

// Trainee.php
        public function subdistrict()
        {
            return $this->belongsTo(Subdistrict::class, 'subdistrict_of_residence', 'id');
        }

    public function trainingHistory()
    {
        return $this->hasMany(Trainee_Training::class, 'id_trainee', 'id')
            ->join('tr_training', 'map_trainee_training.id_training', '=', 'tr_training.id')
            ->select('tr_training.name as training_name', 'map_trainee_training.active', 'map_trainee_training.is_passed');
    }
    
    
}
