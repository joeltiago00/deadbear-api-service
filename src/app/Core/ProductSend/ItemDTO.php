<?php

namespace App\Core\ProductSend;

class ItemDTO
{
    public function __construct(
        public readonly string $login,
        public readonly string $password,
        public readonly string $email
    )
    {
    }
}
