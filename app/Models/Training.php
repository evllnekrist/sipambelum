<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;
use App\Models\Trainee_Training;

class Training extends Model
{
    use SoftDeletes;

    protected $table = 'tr_training';
    protected $fillable = [
        'level',
        'trainee_limit',
        'organizer',
        'local_pontential_id',
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

    
    public function trainees()
    {
        return $this->hasMany(Trainee_Training::class,'id_training','id');
    }
}