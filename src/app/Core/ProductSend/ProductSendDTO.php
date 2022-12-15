<?php

namespace App\Core\ProductSend;

class ProductSendDTO
{
    /**
     * @param string $purchaseCode
     * @param ItemDTO[] $items
     */
    public function __construct(
        public readonly string $purchaseCode,
        public readonly array $items
    )
    {
    }
}
