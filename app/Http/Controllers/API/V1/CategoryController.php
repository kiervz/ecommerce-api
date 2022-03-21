<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name')
            ->where('deleted_at', null)
            ->paginate(10);

        return response()->json([
            'message' => 'retrieved successfully',
            'data' => $categories
        ], 200);
    }

    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request['name'],
            'segment_id' => $request['segment_id']
        ]);

        return response()->json([
            'message' => 'added successfully'
        ], 200);
    }

    public function update(CategoryRequest $request, $id)
    {
        $status_code = 200;
        $message = "updated successfully";

        $category = Category::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($category) {
            $category->update([
                'name' => $request['name']
            ]);
        } else {
            $status_code = 404;
            $message = "category not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function destroy($id)
    {
        $status_code = 200;
        $message = "deleted successfully";

        $category = Category::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($category) {
            $category->update([
                'deleted_at' => now()
            ]);
        } else {
            $status_code = 404;
            $message = "category not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }
}
