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
        "po_number",
        "po_date",
        "total_quantity",
        "total_amount",
        "status",
        "payment_mode_id",
        "payment_status",
        "paid_amount",
        "deleted_at"
    ];

    public static $statusDescription = [
        'P' => 'Pending',
        'C' => 'Cancelled',
        'D' => 'Declined',
        'O' => 'Delivered',
    ];

    public static $paymentstatusDescription = [
        'O' => 'Paid',
        'P' => 'For Payment',
        'E' => 'Error',
        'F' => 'Failed',
        'V' => 'For Verification',
    ];

    public function getStatusTextAttribute()
    {
        return static::$statusDescription[$this->attributes['status']] ?? 'P';
    }

    public function getPaymentStatusTextAttribute()
    {
        return static::$paymentstatusDescription[$this->attributes['payment_status']] ?? 'P';
    }
}
