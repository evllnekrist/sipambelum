<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;
use App\Models\Trainee_Training;
use App\Models\LocalPotential;

class Training extends Model
{
    use SoftDeletes;

    protected $table = 'tr_training';
    protected $fillable = [
        'level',
        'trainee_limit',
        'organizer',
        'id_local_potential',
        'subdistricts',
        'name',
        'desc',
        'img_main',
        'file_main',
        'is_online',
        'address',
        'contact_phone',
        'contact_email',
        'event_start',
        'event_end',
    ];

    public function local_potential()
    {
        return $this->hasOne(LocalPotential::class,'id','id_local_potential');
    }
    
    public function trainees()
    {
        return $this->hasMany(Trainee_Training::class,'id_training','id');
    }
}