<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRequest;
use App\Http\Resources\V1\StoreResource;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::where("deleted_at", null)->paginate(20);

        return StoreResource::collection($stores);
    }

    public function show($slug)
    {
        $status_code = 200;
        $message = "success";

        $store = Store::where([
            "slug" => $slug,
            "deleted_at" => null
        ])->first();

        if (!$store) {
            $message = "store not found.";
            $status_code = 404;
        }

        return response()->json([
            "message" => $message,
            "data" => $store ? new StoreResource($store) : null
        ], $status_code);
    }

    public function store(StoreRequest $request)
    {
        $status_code = 200;
        $message = "added successfully";

        if (!auth()->user()->seller) {
            $message = "unable to create store, you are not a selller.";
            $status_code = 422;
        } else {
            Store::create([
                "seller_id" => auth()->user()->seller->id,
                "name" => $request["name"],
                "slug" => Str::slug($request["name"]),
                "bio" => $request["bio"],
                "last_log" => now()
            ]);
        }

        return response()->json([
            "message" => $message
        ], $status_code);
    }

    public function update(StoreRequest $request, $id)
    {
        $status_code = 200;
        $message = "updated successfully";

        $store = Store::where([
            "id" => $id,
            "deleted_at" => null
        ])->first();

        if ($store) {
            $store->update([
                "name" => $request["name"],
                "slug" => Str::slug($request["name"]),
                "bio" => $request["bio"]
            ]);
        } else {
            $status_code = 404;
            $message = "store not found";
        }

        return response()->json([
            "message" => $message
        ], $status_code);
    }

    public function destroy($id)
    {
        $status_code = 200;
        $message = "deleted successfully";

        $store = Store::where([
            'id' => $id,
            'deleted_at' => null
        ])->first();

        if ($store) {
            $store->update([
                'deleted_at' => now()
            ]);
        } else {
            $status_code = 404;
            $message = "store not found";
        }

        return response()->json([
            'message' => $message
        ], $status_code);
    }
}
