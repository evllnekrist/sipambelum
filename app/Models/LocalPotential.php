<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class LocalPotential extends Model
{
    use SoftDeletes;

    protected $table = 'ms_local_potential';
    protected $fillable = [
        'name',
        'desc',
        'img_main',
        'url_link',
        'active',
    ];
    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict', 'id');
    }
    public function subdistricts()
{
    return $this->belongsToMany(Subdistrict::class, 'map_subdistrict_local_potential', 'id_local_potential', 'id_subdistrict');
}

}