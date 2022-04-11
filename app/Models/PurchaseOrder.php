<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        "seller_id",
        "customer_id",
        "ref_no",
        "po_date",
        "total_quantity",
        "total_amount",
        "status",
        "payment_mode_id",
        "payment_status",
        "paid_amount",
        "deleted_at"
    ];
}
