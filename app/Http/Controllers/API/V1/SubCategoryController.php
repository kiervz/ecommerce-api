<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\SubCategoryRequest;
use App\Http\Resources\V1\SubCategoryResource;
use Illuminate\Http\Request;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index()
    {
        $sub_categories = SubCategory::where('deleted_at', null)->paginate(10);

        return response()->json([
            'message' => 'retrieved succesfully',
            'data' => SubCategoryResource::collection($sub_categories)
        ], 200);
    }

    public function store(SubCategoryRequest $request)
    {
        SubCategory::create([
            'name' => $request['name'],
            'category_id' => $request['category_id']
        ]);

        return response()->json([
            'message' => 'added successfully'
        ], 200);
    }

    public function update(SubCategoryRequest $request, $id)
    {
        $status_code = 200;
        $message = "updated successfully";

        $sub_category = SubCategory::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($sub_category) {
            $sub_category->update([
                'name' => $request['name']
            ]);
        } else {
            $status_code = 404;
            $message = "sub category not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function destroy($id)
    {
        $status_code = 200;
        $message = "deleted successfully";

        $sub_category = SubCategory::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($sub_category) {
            $sub_category->update([
                'deleted_at' => now()
            ]);
        } else {
            $status_code = 404;
            $message = "sub category not found";
        }
        return response()->json([
            'message' => $message
        ], $status_code);
    }
}
