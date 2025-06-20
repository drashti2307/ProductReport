<?php

namespace App\Models;

use Database\Factories\ProductReportFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReport extends Model
{
    /** @use HasFactory<\Database\Factories\ProductReportFactory> */
    use HasFactory;

    protected $fillable = [
        'product_id',
        'report_date',
        'remaining_qty',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    // protected static function newFactory()
    // {
    //     return ProductReportFactory::new();
    // }
}
