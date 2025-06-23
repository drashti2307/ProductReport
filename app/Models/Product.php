<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;


    protected $fillable = [
        'p_name',
        'total_qty',
    ];

    public function productReport()
    {
        return $this->hasMany(ProductReport::class, 'product_id');
    }
}
