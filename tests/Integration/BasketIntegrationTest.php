<?php

declare(strict_types=1);

namespace Acme\Cart\Tests\Integration;

use Acme\Cart\Factory\BasketFactory;
use Acme\Cart\ValueObjects\ProductCode;
use PHPUnit\Framework\TestCase;

final class BasketIntegrationTest extends TestCase
{
    /**
     * Test all provided examples to ensure correct calculations
     *
     * @dataProvider basketExamplesProvider
     */
    public function testBasketCalculationsMatchExpectedTotals(array $productCodes, float $expectedTotal): void
    {
        $basket = BasketFactory::createWithDefaultConfiguration();

        foreach ($productCodes as $code) {
            $basket->add(new ProductCode($code));
        }

        $total = $basket->total();

        $this->assertSame($expectedTotal, $total->toDollars());
    }

    public static function basketExamplesProvider(): array
    {
        return [
            'B01, G01' => [['B01', 'G01'], 37.85],
            'R01, R01' => [['R01', 'R01'], 54.37],
            'R01, G01' => [['R01', 'G01'], 60.85],
            'B01, B01, R01, R01, R01' => [['B01', 'B01', 'R01', 'R01', 'R01'], 98.27],
        ];
    }

    public function testBasketBreakdown(): void
    {
        $basket = BasketFactory::createWithDefaultConfiguration();

        // Add products: R01, R01 (should trigger offer)
        $basket->add(new ProductCode('R01'));
        $basket->add(new ProductCode('R01'));

        $subtotal = $basket->getSubtotal();
        $discounts = $basket->getDiscounts();
        $deliveryCharge = $basket->getDeliveryCharge();
        $total = $basket->total();

        // Verify breakdown
        $this->assertSame(65.90, $subtotal->toDollars()); // 2 * $32.95
        $this->assertSame(16.48, $discounts->toDollars()); // 50% off second widget
        $this->assertSame(4.95, $deliveryCharge->toDollars()); // Under $50 after discount
        $this->assertSame(54.37, $total->toDollars()); // Final total
    }

    public function testEmptyBasket(): void
    {
        $basket = BasketFactory::createWithDefaultConfiguration();

        $total = $basket->total();

        $this->assertSame(0.00, $total->toDollars());
    }

    public function testInvalidProductCode(): void
    {
        $basket = BasketFactory::createWithDefaultConfiguration();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Product 'INVALID' not found in catalogue");

        $basket->add(new ProductCode('INVALID'));
    }
}
