<?php

declare(strict_types=1);

namespace Acme\Cart\Tests\Unit\Services\Offers;

use Acme\Cart\Entities\BasketItem;
use Acme\Cart\Entities\Product;
use Acme\Cart\Services\Offers\RedWidgetBuyOneGetSecondHalfPriceOffer;
use Acme\Cart\Services\ProductCatalogue;
use Acme\Cart\ValueObjects\Money;
use Acme\Cart\ValueObjects\ProductCode;
use PHPUnit\Framework\TestCase;

final class RedWidgetBuyOneGetSecondHalfPriceOfferTest extends TestCase
{
    private RedWidgetBuyOneGetSecondHalfPriceOffer $offer;
    private ProductCatalogue $catalogue;

    protected function setUp(): void
    {
        $this->offer = new RedWidgetBuyOneGetSecondHalfPriceOffer();

        $redWidget = new Product(
            new ProductCode('R01'),
            'Red Widget',
            Money::fromDollars(32.95)
        );

        $this->catalogue = new ProductCatalogue([$redWidget]);
    }

    public function testNoDiscountForSingleRedWidget(): void
    {
        $items = [
            new BasketItem(new ProductCode('R01'), 1)
        ];

        $discount = $this->offer->calculateDiscount($items, $this->catalogue);

        $this->assertSame(0.00, $discount->toDollars());
    }

    public function testDiscountForTwoRedWidgets(): void
    {
        $items = [
            new BasketItem(new ProductCode('R01'), 2)
        ];

        $discount = $this->offer->calculateDiscount($items, $this->catalogue);

        // Second widget gets 50% discount: $32.95 * 0.5 = $16.475 ≈ $16.48
        $this->assertSame(16.48, $discount->toDollars());
    }

    public function testDiscountForThreeRedWidgets(): void
    {
        $items = [
            new BasketItem(new ProductCode('R01'), 3)
        ];

        $discount = $this->offer->calculateDiscount($items, $this->catalogue);

        // Only one widget gets discount (second one)
        $this->assertSame(16.48, $discount->toDollars());
    }

    public function testDiscountForFourRedWidgets(): void
    {
        $items = [
            new BasketItem(new ProductCode('R01'), 4)
        ];

        $discount = $this->offer->calculateDiscount($items, $this->catalogue);

        // Two widgets get discount (2nd and 4th)
        $this->assertSame(32.96, $discount->toDollars());
    }

    public function testNoDiscountForOtherProducts(): void
    {
        $items = [
            new BasketItem(new ProductCode('G01'), 2)
        ];

        $discount = $this->offer->calculateDiscount($items, $this->catalogue);

        $this->assertSame(0.00, $discount->toDollars());
    }

    public function testHasDescription(): void
    {
        $description = $this->offer->getDescription();

        $this->assertSame('Buy one red widget, get the second half price', $description);
    }
}
