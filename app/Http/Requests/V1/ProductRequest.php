<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->product;
        $method = $this->method();

        return [
            'sku' => $method == 'PUT' ? [
                'required',
                Rule::unique('products')->ignore($id)
            ] : 'required|unique:products,sku',
            'name' => 'required',
            'unit_price' => 'required|numeric',
            'discount' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'required',
            'seller_id' => 'required|integer',
            'brand_id' => 'required|integer',
            'segment_id' => 'required|integer',
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer'
        ];
    }
}
