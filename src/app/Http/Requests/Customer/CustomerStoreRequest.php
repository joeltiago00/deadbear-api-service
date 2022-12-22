<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|min:3|max:60',
            'last_name' => 'nullable|string|min:3|max:60',
            'email' => 'required|email:filter,rfc',
            'document_number' => 'required|string|min:11|max:11',
            'phone_number' => 'required|string|min:13|max:14',
        ];
    }
}
