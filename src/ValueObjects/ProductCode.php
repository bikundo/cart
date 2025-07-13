<?php

declare(strict_types=1);

namespace Acme\Cart\ValueObjects;

use InvalidArgumentException;

/**
 * Immutable value object representing a product code
 */
final readonly class ProductCode
{
    public function __construct(
        private string $code
    ) {
        if (empty(trim($code))) {
            throw new InvalidArgumentException('Product code cannot be empty');
        }
    }

    public function getValue(): string
    {
        return $this->code;
    }

    public function equals(ProductCode $other): bool
    {
        return $this->code === $other->code;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
