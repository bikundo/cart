<?php

declare(strict_types=1);

namespace Acme\Cart\Contracts;

use Acme\Cart\Entities\Product;
use Acme\Cart\ValueObjects\ProductCode;

/**
 * Contract for product catalogue operations
 */
interface ProductCatalogueInterface
{
    public function getProduct(ProductCode $code): Product;

    public function hasProduct(ProductCode $code): bool;
}
