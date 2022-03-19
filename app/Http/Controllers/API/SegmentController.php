<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Segment\SegmentRequest;
use App\Models\Segment;
use Illuminate\Http\Request;

class SegmentController extends Controller
{
    public function index()
    {
        $status_code = 200;
        $message = "retrieved successfully";

        $segments = Segment::select('id', 'name')
            ->where('deleted_at', null)
            ->paginate(10);

        return response()->json([
            'message' => $message,
            'data' => $segments
        ], $status_code);
    }

    public function store(SegmentRequest $request)
    {
        $status_code = 200;
        $message = "added successfully";

        Segment::create([
            'name' => $request['name']
        ]);

        return response()->json([
            'message' => $message
        ], $status_code);
    }

    public function update(Request $request, $id)
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
}
