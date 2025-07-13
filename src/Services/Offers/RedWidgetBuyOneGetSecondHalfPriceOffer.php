<?php

declare(strict_types=1);

namespace Acme\Cart\Services\Offers;

use Acme\Cart\Contracts\OfferInterface;
use Acme\Cart\Contracts\ProductCatalogueInterface;
use Acme\Cart\ValueObjects\Money;
use Acme\Cart\ValueObjects\ProductCode;

/**
 * Buy one red widget, get the second half price offer
 */
final class RedWidgetBuyOneGetSecondHalfPriceOffer implements OfferInterface
{
    private const RED_WIDGET_CODE = 'R01';

    public function calculateDiscount(array $items, ProductCatalogueInterface $catalogue): Money
    {
        $redWidgetCode = new ProductCode(self::RED_WIDGET_CODE);
        $redWidgetQuantity = 0;

        // Find red widget quantity in basket
        foreach ($items as $item) {
            if ($item->getProductCode()->equals($redWidgetCode)) {
                $redWidgetQuantity = $item->getQuantity();
                break;
            }
        }

        if ($redWidgetQuantity < 2) {
            return Money::zero();
        }

        // Calculate discount for every second red widget
        $discountedItems = intval($redWidgetQuantity / 2);
        $redWidget = $catalogue->getProduct($redWidgetCode);
        $discountPerItem = $redWidget->getPrice()->multiply(0.5);

        return $discountPerItem->multiply($discountedItems);
    }

    public function getDescription(): string
    {
        return 'Buy one red widget, get the second half price';
    }
}
