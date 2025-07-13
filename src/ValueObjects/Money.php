<?php

declare(strict_types=1);

namespace Acme\Cart\ValueObjects;

use InvalidArgumentException;

/**
 * Immutable value object representing a monetary amount
 */
final readonly class Money
{
    public function __construct(
        private int $amountInCents
    ) {
        if ($amountInCents < 0) {
            throw new InvalidArgumentException('Amount cannot be negative');
        }
    }

    public static function fromDollars(float $dollars): self
    {
        return new self((int) round($dollars * 100));
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public function add(Money $other): self
    {
        return new self($this->amountInCents + $other->amountInCents);
    }

    public function subtract(Money $other): self
    {
        return new self($this->amountInCents - $other->amountInCents);
    }

    public function multiply(float $multiplier): self
    {
        return new self((int) round($this->amountInCents * $multiplier));
    }

    public function isGreaterThanOrEqual(Money $other): bool
    {
        return $this->amountInCents >= $other->amountInCents;
    }

    public function isLessThan(Money $other): bool
    {
        return $this->amountInCents < $other->amountInCents;
    }

    public function toDollars(): float
    {
        return $this->amountInCents / 100.0;
    }

    public function toFormattedString(): string
    {
        return '$' . number_format($this->toDollars(), 2);
    }

    public function getAmountInCents(): int
    {
        return $this->amountInCents;
    }
}
