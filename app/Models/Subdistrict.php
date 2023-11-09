<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Subdistrict extends Model
{
    use SoftDeletes;

    protected $table = 'ms_subdistrict';
    protected $fillable = [
        'name',
        'active',
    ];

    public static function getSubdistrictNameById($id)
    {
        $subdistrict = Subdistrict::find($id);
        return $subdistrict ? $subdistrict->name : null;
    }   
    public function localPotentials()
{
    return $this->belongsToMany(LocalPotential::class, 'map_subdistrict_local_potential', 'id_subdistrict', 'id_local_potential');
}

}