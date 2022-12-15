<?php

namespace App\Mail;

use App\Core\ProductSend\ItemDTO;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseSendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param ItemDTO[] $dtos
     */
    public function __construct(private readonly Customer $customer, private readonly array $dtos)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name')
            ->with([
                'customer' => $this->customer,
                'accounts' => $this->dtos
            ]);
    }
}
