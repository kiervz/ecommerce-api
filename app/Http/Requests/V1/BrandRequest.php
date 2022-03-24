<?php

namespace App\Http\Requests\V1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        $id = $this->brand;
        $method = $this->method();

        return [
            'name' => $method == 'PUT' ? [
                'required',
                Rule::unique('brands')->ignore($id)
            ] : 'required|unique:brands,name',
        ];
    }
}
