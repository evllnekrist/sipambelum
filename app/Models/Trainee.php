<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Trainee_Training;
use App\Models\Trainee_Business;

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

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_of_residence', 'id');
    }

    public function trainingHistory()
    {
        return $this->hasMany(Trainee_Training::class, 'id_trainee', 'id')
            ->join('tr_training', 'map_trainee_training.id_training', '=', 'tr_training.id')
            ->select('tr_training.id', 'tr_training.name as training_name', 'map_trainee_training.active', 'map_trainee_training.is_passed');
    }

    public function businessHistory()
    {
        return $this->hasMany(Trainee_Business::class, 'id_trainee', 'id')
            ->join('ms_business', 'map_trainee_business.id_business', '=', 'ms_business.id')
            ->join('ms_local_potential', 'ms_local_potential.id', '=', 'ms_business.id_local_potential')
            ->select(
                'map_trainee_business.id','map_trainee_business.active','map_trainee_business.job_title',
                'ms_business.id as business_id','ms_business.name','ms_business.phone','ms_business.email','ms_business.address','ms_business.subdistrict'
            );
    }
    
    
}
