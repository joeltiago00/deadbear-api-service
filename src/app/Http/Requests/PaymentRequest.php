<?php

namespace App\Http\Requests;

use App\Exceptions\Payment\PaymentMethodInvalidException;
use App\Types\PaymentMethodTypes;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
     * @return array
     * @throws PaymentMethodInvalidException
     */
    public function rules(): array
    {
        $name_controller = $this->route()->action['controller'];

        if (str_contains($name_controller, '@makeTransaction')) {
            if ($this->payment_method === PaymentMethodTypes::CREDIT_CARD)
                return $this->validationCreditCardTransaction();

            if ($this->payment_method === PaymentMethodTypes::PIX)
                return $this->validationPixTransaction();

            throw new PaymentMethodInvalidException();
        }
    }

    /**
     * @return array
     */
    private function validationCreditCardTransaction(): array
    {
        $rules = [
            'payment_method' => 'required|in:credit_card,pix',
            'is_delivery' => 'required|bool',
            'card.holder_name' => 'required|string|min:3|max:60',
            'card.number' => 'required|string|min:15|max:16',
            'card.expiration_date' => 'required|string|min:4|max:4',
            'card.cvv' => 'required|string|min:3|max:4',
            'customer.name' => 'required|string|min:3|max:60',
            'customer.email' => 'required|email:filter,rfc',
            'customer.document_number' => 'required|string|min:11|max:11',
            'customer.phone_number' => 'required|string|min:13|max:14',
            'billing.name' => 'required|string|min:3|max:60',
            'billing.address.country' => 'required|string|min:2|max:3',
            'billing.address.street' => 'required|string|min:3|max:80',
            'billing.address.number' => 'required|string|min:1|max:10',
            'billing.address.city' => 'required|string|min:3|max:60',
            'billing.address.state' => 'required|string|min:2|max:60',
            'billing.address.zipcode' => 'required|string|min:2|max:60',
            'items.*.id' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|numeric|min:1'
        ];

        if ($this->is_delivery)
            $rules = array_merge($rules, [
                'shipping.name' => 'required|string|min:3|max:60',
                'shipping.fee' => 'required|numeric',
                'shipping.address.country' => 'required|string|min:2|max:3',
                'shipping.address.street' => 'required|string|min:3|max:80',
                'shipping.address.number' => 'required|string|min:1|max:10',
                'shipping.address.city' => 'required|string|min:3|max:60',
                'shipping.address.state' => 'required|string|min:2|max:60',
                'shipping.address.zipcode' => 'required|string|min:2|max:60',
            ]);

        return $rules;
    }

    /**
     * @return array
     */
    private function validationPixTransaction(): array
    {
        $rules = [
            'payment_method' => 'required|in:credit_card,pix',
            'is_delivery' => 'required|bool',
            'customer.name' => 'required|string|min:3|max:60',
            'customer.email' => 'required|email:filter,rfc',
            'customer.document_number' => 'required|string|min:11|max:11',
            'customer.phone_number' => 'required|string|min:13|max:14',
            'items.*.id' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|numeric|min:1'
        ];

        if ($this->is_delivery)
            $rules = array_merge($rules, [
                'shipping.name' => 'required|string|min:3|max:60',
                'shipping.fee' => 'required|numeric',
                'shipping.address.country' => 'required|string|min:2|max:3',
                'shipping.address.street' => 'required|string|min:3|max:80',
                'shipping.address.number' => 'required|string|min:1|max:10',
                'shipping.address.city' => 'required|string|min:3|max:60',
                'shipping.address.state' => 'required|string|min:2|max:60',
                'shipping.address.zipcode' => 'required|string|min:2|max:60',
            ]);

        return $rules;
    }
}
