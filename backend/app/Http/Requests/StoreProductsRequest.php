<?php

namespace App\Http\Requests;

class StoreProductsRequest extends BaseRequest
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
            'name' => 'required|unique:products|max:500|min:3',
            'description' => 'required|min:3',
            'img' => 'image|mimes:jpeg,png,jpg',
            'price' => 'required|min:0',
        ];
    }
}
