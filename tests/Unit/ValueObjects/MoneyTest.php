<?php

declare(strict_types=1);

namespace Acme\Cart\Tests\Unit\ValueObjects;

use Acme\Cart\ValueObjects\Money;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase
{
    public function testCanCreateMoneyFromCents(): void
    {
        $money = new Money(100);
        $this->assertSame(100, $money->getAmountInCents());
    }

    public function testCanCreateMoneyFromDollars(): void
    {
        $money = Money::fromDollars(1.00);
        $this->assertSame(100, $money->getAmountInCents());
        $this->assertSame(1.00, $money->toDollars());
    }

    public function testCannotCreateNegativeMoney(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount cannot be negative');

        new Money(-1);
    }

    public function testCanAddMoney(): void
    {
        $money1 = Money::fromDollars(10.00);
        $money2 = Money::fromDollars(5.50);

        $result = $money1->add($money2);

        $this->assertSame(15.50, $result->toDollars());
    }

    public function testCanSubtractMoney(): void
    {
        $money1 = Money::fromDollars(10.00);
        $money2 = Money::fromDollars(3.50);

        $result = $money1->subtract($money2);

        $this->assertSame(6.50, $result->toDollars());
    }

    public function testCanMultiplyMoney(): void
    {
        $money = Money::fromDollars(10.00);

        $result = $money->multiply(0.5);

        $this->assertSame(5.00, $result->toDollars());
    }

    public function testCanCompareAmounts(): void
    {
        $money1 = Money::fromDollars(10.00);
        $money2 = Money::fromDollars(5.00);
        $money3 = Money::fromDollars(10.00);

        $this->assertTrue($money1->isGreaterThanOrEqual($money2));
        $this->assertTrue($money1->isGreaterThanOrEqual($money3));
        $this->assertTrue($money2->isLessThan($money1));
        $this->assertFalse($money1->isLessThan($money3));
    }

    public function testCanFormatAsString(): void
    {
        $money = Money::fromDollars(32.95);

        $this->assertSame('$32.95', $money->toFormattedString());
    }

    public function testZeroAmount(): void
    {
        $zero = Money::zero();

        $this->assertSame(0, $zero->getAmountInCents());
        $this->assertSame(0.00, $zero->toDollars());
    }
}
