<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ProductDetailMasterRequest;
use App\Models\ProductDetailMaster;
use Illuminate\Http\Request;

class ProductDetailMasterController extends Controller
{
    public function index()
    {
        $product_detail_masters = ProductDetailMaster::select('id', 'name')
            ->where('deleted_at', null)
            ->paginate(10);

        return response()->json([
            'message' => 'retrieved successfully',
            'data' => $product_detail_masters
        ], 200);
    }

    public function store(Request $request)
    {
        ProductDetailMaster::create([
            'name' => $request['name']
        ]);

        return response()->json([
            'message' => 'added successfully'
        ], 200);
    }

    public function update(ProductDetailMasterRequest $request, $id)
    {
        $status_code = 200;
        $message = "updated successfully";

        $product_detail_master = ProductDetailMaster::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($product_detail_master) {
            $product_detail_master->update([
                'name' => $request['name']
            ]);
        } else {
            $status_code = 404;
            $message = "product detail master not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function destroy($id)
    {

        $status_code = 200;
        $message = "deleted successfully";

        $product_detail_master = ProductDetailMaster::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($product_detail_master) {
            $product_detail_master->update([
                'deleted_at' => now()
            ]);
        } else {
            $status_code = 404;
            $message = "product detail master not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }
}
