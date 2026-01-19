<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subdistrict extends Model
{
    //
    use HasFactory;

    protected $table = 'subdistricts';
    protected $primaryKey = 'subdistrict_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'district_id',
        'name_th',
        'name_en',
        'lat',
        'long', // หรือ "long" ถ้าใช้แบบนั้น
        'zipcode',
    ];

    public $timestamps = false;

    /**
     * Subdistrict belongs to district
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
