<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    //
    use HasFactory;

    protected $table = 'provinces';

    protected $fillable = [
        'name_th',
        'name_en',
    ];

    public $timestamps = false; // ถ้า table ไม่มี created_at, updated_at

    /**
     * Province has many districts
     */

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'province_id');
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'province_id');
    }
}
