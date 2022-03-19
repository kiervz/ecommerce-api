<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;


class ProductController extends Controller
{
    public function index()
    {
        $status_code = 200;
        $message = "retrieved successfully";

        $products = Product::where('deleted_at', null)->paginate(10);

        return response()->json([
            'message' => $message,
            'data' => $products
        ], $status_code);
    }

    public function store(ProductRequest $request)
    {
        $status_code = 200;
        $message = "added successfully";

        Product::create([
            'sku' => $request['sku'],
            'name' => $request['name'],
            'slug' => Str::slug($request['name']) . '-' . rand(100,999),
            'unit_price' => $request['unit_price'],
            'discount' => $request['discount'],
            'stock' => $request['stock'],
            'description' => $request['description'],
            'seller_id' => $request['seller_id'],
            'brand_id' => $request['brand_id'],
            'segment_id' => $request['segment_id'],
            'category_id' => $request['category_id'],
            'sub_category_id' => $request['sub_category_id']
        ]);

        foreach ($request->product_details as $item) {
            ProductDetail::create([
                'product_id' => $item['product_id'],
                'product_detail_master_id' => $item['product_detail_master_id'],
                'value' => $item['value']
            ]);
        }

        foreach ($request->product_images as $item) {
            ProductImage::create([
                'product_id' => $item['product_id'],
                'image' => $item['image']
            ]);
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function update(ProductRequest $request, $id)
    {
        $status_code = 200;
        $message = "updated successfully";

        $product = Product::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($product) {
            $product->update([
                'sku' => $request['sku'],
                'name' => $request['name'],
                'unit_price' => $request['unit_price'],
                'discount' => $request['discount'],
                'stock' => $request['stock'],
                'description' => $request['description'],
                'seller_id' => $request['seller_id'],
                'brand_id' => $request['brand_id'],
                'segment_id' => $request['segment_id'],
                'category_id' => $request['category_id'],
                'sub_category_id' => $request['sub_category_id']
            ]);
        } else {
            $status_code = 404;
            $message = "Product not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function destroy($id)
    {
        $status_code = 200;
        $message = "deleted successfully";

        $product = Product::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($product) {
            $product->update([
                'deleted_at' => now()
            ]);
        } else {
            $status_code = 404;
            $message = "Product not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }
}
