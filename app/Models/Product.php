<?php

namespace App\Models;

use phpDocumentor\Reflection\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "name",
        "slug",
        "sku",
        "description",
        "qty",
        "price",
        "cost_price",
        "stock",
        "thumbnail",
        "status",
        "category_id",
    ];

    protected $appends = ['thumbnail_api'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    

    public function locations()
    {
        return $this->belongsToMany(Location::class)
            ->withPivot('stock_qty', 'price')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity', 'price');
    }



    public function getThumbnailApiAttribute()
    {
        return $this->thumbnail ? asset($this->thumbnail) : null;
    }
}
