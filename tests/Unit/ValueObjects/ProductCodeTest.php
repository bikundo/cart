<?php

declare(strict_types=1);

namespace Acme\Cart\Tests\Unit\ValueObjects;

use Acme\Cart\ValueObjects\ProductCode;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ProductCodeTest extends TestCase
{
    public function testCanCreateValidProductCode(): void
    {
        $code = new ProductCode('R01');

        $this->assertSame('R01', $code->getValue());
        $this->assertSame('R01', (string) $code);
    }

    public function testCannotCreateEmptyProductCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code cannot be empty');

        new ProductCode('');
    }

    public function testCannotCreateWhitespaceOnlyProductCode(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Product code cannot be empty');

        new ProductCode('   ');
    }

    public function testCanCompareProductCodes(): void
    {
        $code1 = new ProductCode('R01');
        $code2 = new ProductCode('R01');
        $code3 = new ProductCode('G01');

        $this->assertTrue($code1->equals($code2));
        $this->assertFalse($code1->equals($code3));
    }
}
