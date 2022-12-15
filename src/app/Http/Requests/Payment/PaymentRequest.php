<?php

namespace App\Http\Requests\Payment;

use App\Enums\Payment\PaymentMethodEnum;
use App\Exceptions\Payment\InvalidPostback;
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
     * @throws InvalidPostback
     */
    public function rules(): array
    {
        $name_controller = $this->route()->action['controller'];

        if (str_contains($name_controller, '@makeTransaction')) {
            if ($this->payment_method === PaymentMethodEnum::CREDITCARD->description())
                return $this->validationCreditCardTransaction();

            if ($this->payment_method === PaymentMethodEnum::PIX->description())
                return $this->validationPixTransaction();

            if ($this->payment_method === PaymentMethodEnum::BOLETO->description())
                return $this->validationBoletoTransaction();

            throw new InvalidPostback();
        }
    }

    private function validationCreditCardTransaction(): array
    {
        return [
            'payment_method' => 'required|in:credit_card',
            'card.holder_name' => 'required|string|min:3|max:60',
            'card.number' => 'required|string|min:15|max:16',
            'card.expiration_date' => 'required|string|min:4|max:4',
            'card.cvv' => 'required|string|min:3|max:4',
            'billing.name' => 'required|string|min:3|max:60',
            'billing.address.country' => 'required|string|min:2|max:3',
            'billing.address.street' => 'required|string|min:3|max:80',
            'billing.address.number' => 'required|string|min:1|max:30',
            'billing.address.neighborhood' => 'required|string|min:1|max:80',
            'billing.address.city' => 'required|string|min:3|max:60',
            'billing.address.state' => 'required|string|min:2|max:60',
            'billing.address.zipcode' => 'required|string|min:2|max:60',
            'items.*.id' => 'required|string|min:1',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:100',
            'items.*.title' => 'required|string|min:3|max:100',
            'items.*.tangible' => 'required|boolean',
        ];
    }

    private function validationPixTransaction(): array
    {
        return [
            'payment_method' => 'required|in:pix',
            'is_delivery' => 'required|bool',
            'items.*.id' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:100',
            'items.*.title' => 'required|string|min:3|max:100',
            'items.*.tangible' => 'required|boolean',
        ];
    }

    private function validationBoletoTransaction(): array
    {
        return [
            'payment_method' => 'required|in:boleto',
            'is_delivery' => 'required|bool',
            'items.*.id' => 'required|numeric|min:1',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:100',
            'items.*.title' => 'required|string|min:3|max:100',
            'items.*.tangible' => 'required|boolean',
        ];
    }
}
