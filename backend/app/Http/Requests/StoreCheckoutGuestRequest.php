<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules;

class StoreCheckoutGuestRequest extends BaseRequest
{
    public $billing_address;
    public $shipping_address;
    public $cart;
    public $email;
    public $password;
    public $first_name;
    public $last_name;

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
            'cart' => 'required|json',
            'email' => ['string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'first_name' => ['string', 'max:255', 'min:3'],
            'last_name' => ['string', 'max:255', 'min:3'],
        ];
    }
}
