<?php

declare(strict_types=1);

namespace Acme\Cart\Services;

use Acme\Cart\Contracts\ProductCatalogueInterface;
use Acme\Cart\Entities\Product;
use Acme\Cart\ValueObjects\ProductCode;
use InvalidArgumentException;

/**
 * In-memory product catalogue implementation
 */
final class ProductCatalogue implements ProductCatalogueInterface
{
    /** @var array<string, Product> */
    private array $products = [];

    /**
     * @param Product[] $products
     */
    public function __construct(array $products = [])
    {
        foreach ($products as $product) {
            $this->addProduct($product);
        }
    }

    public function addProduct(Product $product): void
    {
        $this->products[$product->getCode()->getValue()] = $product;
    }

    public function getProduct(ProductCode $code): Product
    {
        if (!$this->hasProduct($code)) {
            throw new InvalidArgumentException("Product with code '{$code->getValue()}' not found");
        }

        return $this->products[$code->getValue()];
    }

    public function hasProduct(ProductCode $code): bool
    {
        return isset($this->products[$code->getValue()]);
    }
}
