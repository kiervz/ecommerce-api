<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "segment_id",
        "is_deleted"
    ];

    public function segment()
    {
        return $this->belongsTo(Segment::class);
    }

    public function subcategory()
    {
        return $this->hasOne(SubCategory::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
