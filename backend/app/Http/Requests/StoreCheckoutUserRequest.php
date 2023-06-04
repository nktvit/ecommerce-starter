<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutUserRequest extends FormRequest
{
    public $billing_address;
    public $shipping_address;
    public $user_id;

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
            'billing_address' => 'required',
            'shipping_address' => 'required',
            'user_id' => 'required|integer',
        ];
    }
}
