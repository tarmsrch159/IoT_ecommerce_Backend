<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'address',
        'province_id',
        'district_id',
        'subdistrict_id',
        'postcode',
        'lat',
        'lng',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['stock_qty', 'price'])
            ->withTimestamps();
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'subdistrict_id', 'subdistrict_id');
    }
}
