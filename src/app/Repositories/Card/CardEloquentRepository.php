<?php

namespace App\Repositories\Card;

use App\Models\Card;
use App\Repositories\Repository;

class CardEloquentRepository extends Repository implements CardRepository
{
    public function __construct()
    {
        $this->setModel(Card::class);
    }
}
