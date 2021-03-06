<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CategoryRequest extends FormRequest
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
        $id = $this->category;
        $method = $this->method();

        return [
            'name' => $method == 'PUT' ? [
                'required',
                Rule::unique('categories')->ignore($id)
            ] : 'required|unique:categories,name',
            'segment_id' => $method == 'PUT' ? '' : 'required'
        ];
    }
}
