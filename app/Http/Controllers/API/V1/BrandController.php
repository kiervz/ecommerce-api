<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BrandRequest;
use App\Http\Resources\V1\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::where('deleted_at', null)->paginate(15);

        return BrandResource::collection($brands);
    }

    public function show($brand)
    {
        $status_code = 200;
        $message = "success";

        $brand = Brand::where([
            'name' => $brand,
            'deleted_at' => null
        ])->first();

        if (!$brand) {
            $message = 'brand not found.';
            $status_code = 404;
        }

        return response()->json([
            'message' => $message,
            'data' => $brand ? new BrandResource($brand) : null
        ], $status_code);
    }

    public function store(BrandRequest $request)
    {
        Brand::create([
            'name' => $request['name']
        ]);

        return response()->json([
            'message' => 'added successfully'
        ], 200);
    }

    public function update(BrandRequest $request, $id)
    {
        $status_code = 200;
        $message = "updated successfully";

        $brand = Brand::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($brand) {
            $brand->update([
                'name' => $request['name']
            ]);
        } else {
            $status_code = 404;
            $message = "brand not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function destroy($id)
    {
        $status_code = 200;
        $message = "deleted successfully";

        $brand = Brand::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($brand) {
            $brand->update([
                'deleted_at' => now()
            ]);
        } else {
            $status_code = 404;
            $message = "brand not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }
}
