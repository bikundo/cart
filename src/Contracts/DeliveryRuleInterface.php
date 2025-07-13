<?php

declare(strict_types=1);

namespace Acme\Cart\Contracts;

use Acme\Cart\ValueObjects\Money;

/**
 * Contract for delivery charge calculation strategies
 */
interface DeliveryRuleInterface
{
    public function calculateDeliveryCharge(Money $subtotal): Money;
}
