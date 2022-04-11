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
}
