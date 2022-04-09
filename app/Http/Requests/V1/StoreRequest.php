<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $id = $this->store;

        $seller_id = auth()->user()->seller == null ?  0 : auth()->user()->seller->id;
        $method = $this->method();

        return [
            'name' => $method == 'PUT' ? [
                'required', Rule::unique('stores')->ignore($id)
            ] : [
                'required', Rule::unique('stores')->where(function($query) use ($seller_id) {
                    $query->where('seller_id', '=', $seller_id);
                })
            ],
            'bio' => $method == 'PUT' ? '' : 'required'
        ];
    }
}
