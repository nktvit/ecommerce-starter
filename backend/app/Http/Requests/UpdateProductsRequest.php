<?php

namespace App\Http\Requests;

class UpdateProductsRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'unique:products|max:500|min:3',
            'description' => 'min:3',
            'img' => 'image|mimes:jpeg,png,jpg',
            'price' => 'min:0',
        ];
    }
}
