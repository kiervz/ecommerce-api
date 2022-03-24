<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductRequest;
use App\Http\Resources\V1\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $status_code = 200;
        $message = "retrieved successfully";

        $sort = $request->get('sort');
        $dir = $request->get('dir');
        $search = $request->get('q');

        $search_products = Product::where(function($query) use ($search) {
            $query->where('slug', 'LIKE', "%$search%")
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('sku', 'LIKE', "%$search%")
                ->orWhere('description', 'LIKE', "%$search%");
            })->where('deleted_at', null);

        if ($sort == null) {
            $search_products->orderBy('created_at', 'DESC');
        } elseif ($sort == 'latest' && $dir == 'asc') {
            $search_products->orderBy('created_at', 'ASC');
        } elseif ($sort == 'discount' && $dir == 'desc') {
            $search_products->orderBy('discount', 'DESC');
        } elseif ($sort == 'discount' && $dir == 'asc') {
            $search_products->orderBy('discount', 'ASC');
        } elseif ($sort == 'price' && $dir == 'desc') {
            $search_products->orderBy('actual_price', 'DESC');
        } elseif ($sort == 'price' && $dir == 'asc') {
            $search_products->orderBy('actual_price', 'ASC');
        }

        $products = $search_products->paginate(10);

        return response()->json([
            'message' => $message,
            'data' => ProductResource::collection($products)
        ], $status_code);
    }

    public function show($slug)
    {
        $status_code = 200;
        $message = "success";

        $product = Product::where([
            'slug' => $slug,
            'deleted_at' => null
        ])->first();

        if (!$product) {
            $message = 'product not found.';
            $status_code = 404;
        }

        return response()->json([
            'message' => $message,
            'data' => $product ? new ProductResource($product) : null
        ], $status_code);
    }

    public function store(ProductRequest $request)
    {
        $status_code = 200;
        $message = "added successfully";

        $product = Product::create([
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
                'product_id' => $product['id'],
                'product_detail_master_id' => $item['product_detail_master_id'],
                'value' => $item['value']
            ]);
        }

        foreach ($request->product_images as $item) {
            ProductImage::create([
                'product_id' => $product['id'],
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
