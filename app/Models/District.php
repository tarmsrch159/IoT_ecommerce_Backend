<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    //
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = [
        'name_th',
        'name_en',
        'province_id',
    ];

    public $timestamps = false;

    /**
     * District belongs to province
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * District has many subdistricts
     */
    public function subdistricts()
    {
        return $this->hasMany(Subdistrict::class, 'district_id');
    }
}
