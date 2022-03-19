<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segment extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "deleted_at"
    ];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
