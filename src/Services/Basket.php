<?php

declare(strict_types=1);

namespace Acme\Cart\Services;

use Acme\Cart\Contracts\DeliveryRuleInterface;
use Acme\Cart\Contracts\OfferInterface;
use Acme\Cart\Contracts\ProductCatalogueInterface;
use Acme\Cart\Entities\BasketItem;
use Acme\Cart\ValueObjects\Money;
use Acme\Cart\ValueObjects\ProductCode;

/**
 * Main basket implementation with dependency injection
 */
final class Basket
{
    /** @var BasketItem[] */
    private array $items = [];

    /**
     * @param OfferInterface[] $offers
     */
    public function __construct(
        private ProductCatalogueInterface $catalogue,
        private DeliveryRuleInterface $deliveryRule,
        private array $offers = []
    ) {
    }

    public function add(ProductCode $productCode): void
    {
        if (!$this->catalogue->hasProduct($productCode)) {
            throw new \InvalidArgumentException("Product '{$productCode->getValue()}' not found in catalogue");
        }

        $existingItem = $this->findItem($productCode);

        if ($existingItem !== null) {
            $existingItem->incrementQuantity();
        } else {
            $this->items[] = new BasketItem($productCode);
        }
    }

    public function total(): Money
    {
        // Return zero for empty baskets
        if (empty($this->items)) {
            return Money::zero();
        }

        $subtotal = $this->calculateSubtotal();
        $discounts = $this->calculateDiscounts();
        $subtotalAfterDiscounts = $subtotal->subtract($discounts);
        $deliveryCharge = $this->deliveryRule->calculateDeliveryCharge($subtotalAfterDiscounts);

        return $subtotalAfterDiscounts->add($deliveryCharge);
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getSubtotal(): Money
    {
        return $this->calculateSubtotal();
    }

    public function getDiscounts(): Money
    {
        return $this->calculateDiscounts();
    }

    public function getDeliveryCharge(): Money
    {
        $subtotalAfterDiscounts = $this->calculateSubtotal()->subtract($this->calculateDiscounts());
        return $this->deliveryRule->calculateDeliveryCharge($subtotalAfterDiscounts);
    }

    private function findItem(ProductCode $productCode): ?BasketItem
    {
        foreach ($this->items as $item) {
            if ($item->getProductCode()->equals($productCode)) {
                return $item;
            }
        }
        return null;
    }

    private function calculateSubtotal(): Money
    {
        $total = Money::zero();

        foreach ($this->items as $item) {
            $product = $this->catalogue->getProduct($item->getProductCode());
            $itemTotal = $product->getPrice()->multiply($item->getQuantity());
            $total = $total->add($itemTotal);
        }

        return $total;
    }

    private function calculateDiscounts(): Money
    {
        $totalDiscount = Money::zero();

        foreach ($this->offers as $offer) {
            $discount = $offer->calculateDiscount($this->items, $this->catalogue);
            $totalDiscount = $totalDiscount->add($discount);
        }

        return $totalDiscount;
    }
}
