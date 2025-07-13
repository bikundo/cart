<?php

declare(strict_types=1);

namespace Acme\Cart\Tests\Unit\Services;

use Acme\Cart\Services\TieredDeliveryRule;
use Acme\Cart\ValueObjects\Money;
use PHPUnit\Framework\TestCase;

final class TieredDeliveryRuleTest extends TestCase
{
    private TieredDeliveryRule $deliveryRule;

    protected function setUp(): void
    {
        $this->deliveryRule = new TieredDeliveryRule();
    }

    public function testCharges495ForOrdersUnder50(): void
    {
        $subtotal = Money::fromDollars(49.99);

        $charge = $this->deliveryRule->calculateDeliveryCharge($subtotal);

        $this->assertSame(4.95, $charge->toDollars());
    }

    public function testCharges295ForOrdersUnder90(): void
    {
        $subtotal = Money::fromDollars(75.00);

        $charge = $this->deliveryRule->calculateDeliveryCharge($subtotal);

        $this->assertSame(2.95, $charge->toDollars());
    }

    public function testFreeDeliveryForOrders90OrMore(): void
    {
        $subtotal = Money::fromDollars(90.00);

        $charge = $this->deliveryRule->calculateDeliveryCharge($subtotal);

        $this->assertSame(0.00, $charge->toDollars());
    }

    public function testEdgeCases(): void
    {
        // Test exactly $50
        $charge = $this->deliveryRule->calculateDeliveryCharge(Money::fromDollars(50.00));
        $this->assertSame(2.95, $charge->toDollars());

        // Test exactly $90
        $charge = $this->deliveryRule->calculateDeliveryCharge(Money::fromDollars(90.00));
        $this->assertSame(0.00, $charge->toDollars());
    }
}
