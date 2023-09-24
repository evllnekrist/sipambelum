<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Auth;
use App\Models\LegalProductStatistics;

class SelectionList extends Model
{
    use SoftDeletes;

    protected $table = 'ms_selection_list';
    protected $fillable = [
        'type',
        'value',
        'value2',
        'label',
        'desc',
        'img_main',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
    ];

    public function legal_product_statistics(){
      return $this->where('type','LEGAL_PRODUCT_TYPE')->hasMany(LegalProductStatistics::class, 'value', 'legal_product_type');
    }
}
