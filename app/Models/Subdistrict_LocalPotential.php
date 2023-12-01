<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Subdistrict_LocalPotential extends Model
{
    use SoftDeletes;

    protected $table = 'map_subdistrict_local_potential';
    protected $fillable = [
        'id_subdistrict',
        'id_local_potential',
    ];
    public function localPotential()
    {
        return $this->belongsTo(LocalPotential::class, 'id_local_potential');
    }
}