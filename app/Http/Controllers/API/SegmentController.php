<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SegmentRequest;
use App\Models\Category;
use App\Models\Segment;
use Illuminate\Http\Request;

class SegmentController extends Controller
{
    public function index()
    {
        $segments = Segment::select('id', 'name')
            ->where('deleted_at', null)
            ->paginate(10);

        return response()->json([
            'message' => 'retrieved successfully',
            'data' => $segments
        ], 200);
    }

    public function store(SegmentRequest $request)
    {
        Segment::create([
            'name' => $request['name']
        ]);

        return response()->json([
            'message' => 'added successfully'
        ], 200);
    }

    public function update(SegmentRequest $request, $id)
    {
        $status_code = 200;
        $message = "updated successfully";

        $segment = Segment::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($segment) {
            $segment->update([
                'name' => $request['name']
            ]);
        } else {
            $status_code = 404;
            $message = "segment not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function destroy($id)
    {
        $status_code = 200;
        $message = "deleted successfully";

        $segment = Segment::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($segment) {
            $segment->update([
                'deleted_at' => now()
            ]);
        } else {
            $status_code = 404;
            $message = "segment not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function showCategoriesBySegmentId($id)
    {
        $status_code = 200;
        $message = "retrieved successfully";

        $segment = Segment::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if (!$segment) {
            $status_code = 404;
            $message = "segment not found";
        } else {
            $categories = Category::select('id', 'name')->where([
                'segment_id' => $segment['id'],
                'deleted_at' => null
            ])->paginate(10);
        }

        return response()->json([
            'message' => $message,
            'data' => $categories ?? null
        ], $status_code);
    }
}
