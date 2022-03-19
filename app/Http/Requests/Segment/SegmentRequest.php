<?php

namespace App\Http\Requests\Segment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SegmentRequest extends FormRequest
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
            'name' => $method == 'PUT' ? [
                'required',
                Rule::unique('segments')->ignore($id)
            ] : 'required|unique:segments,name',
        ];
    }
}
