<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductDetailMasterRequest extends FormRequest
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
        $id = $this->product_detail_master;
        $method = $this->method();

        return [
            'name' => $method == 'PUT' ? [
                'required',
                Rule::unique('product_detail_masters')->ignore($id)
            ] : 'required|unique:product_detail_masters,name',
        ];
    }
}
