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
    public function trainee()
    {
        return $this->belongsTo(Trainee::class,'id_trainee','id');
    }
    public function mapTraineeBusiness()
    {
        return $this->hasMany(MapTraineeBusiness::class, 'id_trainee', 'id');
    }
    public function deleteCascade()
    {
        // Hapus semua karyawan yang terkait dengan id_business ini
        $this->delete();
    }
}