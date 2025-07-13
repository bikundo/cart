<?php

declare(strict_types=1);

namespace Acme\Cart\Contracts;

use Acme\Cart\Entities\BasketItem;
use Acme\Cart\ValueObjects\Money;

/**
 * Contract for special offer calculation strategies
 */
interface OfferInterface
{
    /**
     * Calculate discount for given basket items
     *
     * @param BasketItem[] $items
     * @param ProductCatalogueInterface $catalogue
     */
    public function calculateDiscount(array $items, ProductCatalogueInterface $catalogue): Money;

    public function getDescription(): string;
}
