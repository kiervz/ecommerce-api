<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubCategoryRequest extends FormRequest
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
        $id = $this->sub_category;
        $method = $this->method();

        return [
            'name' => $method == 'PUT' ? [
                'required',
                Rule::unique('sub_categories')->ignore($id)
            ] : [
                'required', Rule::unique('sub_categories')->where(function($query) {
                    $query->where('category_id', '=', $this->category_id);
                })
            ],
            'category_id' => $method == 'PUT' ? '' : 'required'
        ];
    }
}
