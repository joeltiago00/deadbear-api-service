<?php

namespace App\Core\Document\Contracts;

interface DocumentInterface
{
    public function getType(): string;

    public function getValue(): string;

    public function toArray(): array;
}
