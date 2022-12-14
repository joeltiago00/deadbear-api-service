<?php

namespace App\Repositories;

use App\Models\Card;

class CardRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(Card::class);
    }
}
