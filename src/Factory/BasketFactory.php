<?php

declare(strict_types=1);

namespace Acme\Cart\Factory;

use Acme\Cart\Entities\Product;
use Acme\Cart\Services\Basket;
use Acme\Cart\Services\Offers\RedWidgetBuyOneGetSecondHalfPriceOffer;
use Acme\Cart\Services\ProductCatalogue;
use Acme\Cart\Services\TieredDeliveryRule;
use Acme\Cart\ValueObjects\Money;
use Acme\Cart\ValueObjects\ProductCode;

/**
 * Factory for creating pre-configured basket instances
 */
final class BasketFactory
{
    public static function createWithDefaultConfiguration(): Basket
    {
        $catalogue = self::createDefaultCatalogue();
        $deliveryRule = new TieredDeliveryRule();
        $offers = [
            new RedWidgetBuyOneGetSecondHalfPriceOffer(),
        ];

        return new Basket($catalogue, $deliveryRule, $offers);
    }

    private static function createDefaultCatalogue(): ProductCatalogue
    {
        $products = [
            new Product(
                new ProductCode('R01'),
                'Red Widget',
                Money::fromDollars(32.95)
            ),
            new Product(
                new ProductCode('G01'),
                'Green Widget',
                Money::fromDollars(24.95)
            ),
            new Product(
                new ProductCode('B01'),
                'Blue Widget',
                Money::fromDollars(7.95)
            ),
        ];

        return new ProductCatalogue($products);
    }
}
