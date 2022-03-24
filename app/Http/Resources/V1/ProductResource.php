<?php

namespace App\Http\Resources\V1;

use App\Models\Seller;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'unit_price' => $this->unit_price,
            'discount' => $this->discount,
            'actual_price' => $this->actual_price,
            'stock' => $this->stock,
            'seller' => new SellerResource($this->seller),
            'brand' => new BrandResource($this->brand),
            'segment' => $this->segment->name,
            'category' => $this->category->name,
            'sub_ategory' => $this->sub_category->name,
            'description' => $this->description,
            'images' => ProductImageResource::collection($this->product_images),
            'details' => ProductDetailResource::collection($this->product_details)
        ];
    }
}
