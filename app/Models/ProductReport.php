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
        'p_id',
        'report_date',
        'remaining_qty',
    ];

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
    // protected static function newFactory()
    // {
    //     return ProductReportFactory::new();
    // }
}
