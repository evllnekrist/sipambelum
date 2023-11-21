<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;

class Business extends Model
{
    use SoftDeletes;

    protected $table = 'ms_business';
    protected $fillable = [
        'nib',
        'id_local_potential',
        'name',
        'phone',
        'email',
        'address',
        'subdistrict',
        'date_of_establishment',
        'initial_business_capital',
        'revenue',
        'digitalization',
        'employees_count',
        'development_problems',
        'training_needs',
        'is_sales_transaction',
        'is_access_to_funding',
        'is_financial_report',
        'is_business_account',
    ];

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict', 'id');
    }
    public function trainees()
    {
        return $this->hasMany(Trainee_Business::class,'id_business','id');
    }
    public function trainee()
{
    return $this->belongsTo(Trainee::class, 'id_trainee', 'id');
}
    public function localPotential()
    {
        return $this->belongsTo(LocalPotential::class, 'id_local_potential', 'id');
    }

    protected static function booted()
    {
        static::deleting(function ($business) {
            $business->trainees()->deleteCascade();
        });
    }

}