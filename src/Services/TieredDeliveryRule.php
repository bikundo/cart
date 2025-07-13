<?php

declare(strict_types=1);

namespace Acme\Cart\Services;

use Acme\Cart\Contracts\DeliveryRuleInterface;
use Acme\Cart\ValueObjects\Money;

/**
 * Tiered delivery rule implementation
 * - Under $50: $4.95
 * - Under $90: $2.95
 * - $90 or more: Free
 */
final class TieredDeliveryRule implements DeliveryRuleInterface
{
    private const TIER_1_THRESHOLD = 50.00;
    private const TIER_2_THRESHOLD = 90.00;
    private const TIER_1_CHARGE = 4.95;
    private const TIER_2_CHARGE = 2.95;

    public function calculateDeliveryCharge(Money $subtotal): Money
    {
        $amount = $subtotal->toDollars();

        if ($amount < self::TIER_1_THRESHOLD) {
            return Money::fromDollars(self::TIER_1_CHARGE);
        }

        if ($amount < self::TIER_2_THRESHOLD) {
            return Money::fromDollars(self::TIER_2_CHARGE);
        }

        return Money::zero();
    }
}
