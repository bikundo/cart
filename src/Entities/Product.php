<?php

declare(strict_types=1);

namespace Acme\Cart\Entities;

use Acme\Cart\ValueObjects\Money;
use Acme\Cart\ValueObjects\ProductCode;

/**
 * Product entity representing an item in the catalogue
 */
final readonly class Product
{
    public function __construct(
        private ProductCode $code,
        private string $name,
        private Money $price
    ) {
    }

    public function getCode(): ProductCode
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }
}
