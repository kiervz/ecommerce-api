<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "product_detail_master_id",
        "value"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_detail_master()
    {
        return $this->belongsTo(ProductDetailMaster::class);
    }
}
