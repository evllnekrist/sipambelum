<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MapTraineeBusiness extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nama tabel yang digunakan oleh model.
     *
     * @var string
     */
    protected $table = 'map_trainee_business';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'id_business',
        'id_trainee',
        'active',
        'job_title',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /**
     * Atribut yang harus diubah ke tipe data tertentu.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean', // Konversi kolom 'active' menjadi tipe data boolean
    ];

    /**
     * Relasi antara MapTraineeBusiness dengan Business.
     */
    public function business()
    {
        return $this->belongsTo(Business::class, 'id_business', 'id');
    }

    /**
     * Relasi antara MapTraineeBusiness dengan Trainee.
     */
    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'id_trainee', 'id');
    }
}
