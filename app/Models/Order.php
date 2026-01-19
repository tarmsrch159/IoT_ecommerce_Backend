<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        "qty",
        "total",
        "status",
        "province_id",
        "delivered_at",
        "user_id",
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
    public function getDeliveredAtAttribute($value)
    {
        if ($value) {
            return Carbon::parse($value)->diffForHumans();
        } else {
            return null;
        }
    }
}
