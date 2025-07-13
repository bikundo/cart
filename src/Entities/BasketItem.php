<?php

declare(strict_types=1);

namespace Acme\Cart\Entities;

use Acme\Cart\ValueObjects\ProductCode;

/**
 * Represents an item in the basket with its quantity
 */
final class BasketItem
{
    public function __construct(
        private ProductCode $productCode,
        private int $quantity = 1
    ) {
        if ($quantity < 1) {
            throw new \InvalidArgumentException('Quantity must be at least 1');
        }
    }

    public function getProductCode(): ProductCode
    {
        return $this->productCode;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function incrementQuantity(): void
    {
        $this->quantity++;
    }
}
