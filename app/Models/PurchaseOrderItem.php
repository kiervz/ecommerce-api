<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "po_id",
        "product_id",
        "sku",
        "name",
        "slug",
        "variety",
        "quantity",
        "price",
        "total_amount",
        "unit",
        "deleted_at",
    ];
}
