<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "sku",
        "name",
        "slug",
        "unit_price",
        "discount",
        "stock",
        "description",
        "seller_id",
        "brand_id",
        "segment_id",
        "category_id",
        "sub_category_id",
        "deleted_at"
    ];

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function product_details()
    {
        return $this->hasMany(ProductDetail::class);
    }
}
