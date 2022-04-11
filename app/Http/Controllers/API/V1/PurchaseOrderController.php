<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\PurchaseOrderRequest;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function store(PurchaseOrderRequest $request)
    {
        $po = PurchaseOrder::create([
            'seller_id' => $request['seller_id'],
            'customer_id' => $request['customer_id'],
            'ref_no' => $request['ref_no'],
            'po_number' => PurchaseOrder::latest()->first() ? str_pad(PurchaseOrder::latest()->first()->po_number + 1, 15, "0", STR_PAD_LEFT) : '000000000000001',
            'po_date' => $request['po_date'],
            'total_quamtity' => $request['total_quantity'],
            'payment_mode_id' => $request['payment_mode_id'],
            'status' => 'N'
        ]);

        $total_quamtity = 0;
        $total_amount = 0;

        foreach ($request['products'] as $item) {
            $product = Product::where('id', $item['product_id'])->first();

            $po_item = PurchaseOrderItem::create([
                'po_id' => $po['id'],
                'product_id' => $product['id'],
                'sku' => $product['sku'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'variety' => $product['variety'],
                'quantity' => $item['quantity'],
                'price' => $product['actual_price'],
                'total_amount' => $product['actual_price'] * $item['quantity'],
                'unit' => $product['unit']
            ]);

            $total_quamtity += $po_item['quantity'];
            $total_amount += $po_item['total_amount'];
        }

        $po->update([
            'total_quantity' => $total_quamtity,
            'total_amount' => $total_amount
        ]);

        return response()->json([
            'message' => 'purchase order created successfully'
        ], 200);
    }

    public function updateStatus(Request $request)
    {
        $status_code = 200;
        $message = "status updated successfully";

        $po = PurchaseOrder::where([
            'seller_id' => $request['seller_id'],
            'po_number' => $request['po_number']
        ])->first();

        if (!$po) {
            $status_code = 404;
            $message = "purchase order not found";
        } else {
            $po->update([
                'status' => $request['status'],
                'payment_status' => 'O'
            ]);
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function updatePaymentStatus(Request $request)
    {

        $status_code = 200;
        $message = "payment status updated successfully";

        $po = PurchaseOrder::where([
            'seller_id' => $request['seller_id'],
            'po_number' => $request['po_number']
        ])->first();

        if (!$po) {
            $status_code = 404;
            $message = "purchase order not found";
        } else {
            $po->update([
                'payment_status' => $request['status']
            ]);
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }
}
