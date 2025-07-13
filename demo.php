<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Acme\Cart\Factory\BasketFactory;
use Acme\Cart\ValueObjects\ProductCode;

function runBasketDemo(): void
{
    echo "=== Acme Widget Co. Basket Demo ===\n\n";

    $examples = [
        ['B01', 'G01'],
        ['R01', 'R01'],
        ['R01', 'G01'],
        ['B01', 'B01', 'R01', 'R01', 'R01'],
    ];

    foreach ($examples as $index => $productCodes) {
        echo "Example " . ($index + 1) . ": " . implode(', ', $productCodes) . "\n";
        echo str_repeat('-', 40) . "\n";

        $basket = BasketFactory::createWithDefaultConfiguration();

        foreach ($productCodes as $code) {
            $basket->add(new ProductCode($code));
        }

        // Show breakdown
        $subtotal = $basket->getSubtotal();
        $discounts = $basket->getDiscounts();
        $deliveryCharge = $basket->getDeliveryCharge();
        $total = $basket->total();

        echo "Subtotal:       " . $subtotal->toFormattedString() . "\n";
        if ($discounts->toDollars() > 0) {
            echo "Discounts:      -" . $discounts->toFormattedString() . "\n";
        }
        echo "Delivery:       " . $deliveryCharge->toFormattedString() . "\n";
        echo "TOTAL:          " . $total->toFormattedString() . "\n\n";
    }
}

function runInteractiveMode(): void
{
    echo "=== Interactive Basket Mode ===\n";
    echo "Available products: R01 ($32.95), G01 ($24.95), B01 ($7.95)\n";
    echo "Commands: add <code>, total, quit\n\n";

    $basket = BasketFactory::createWithDefaultConfiguration();

    while (true) {
        echo "> ";
        $input = trim(fgets(STDIN));
        $parts = explode(' ', $input);
        $command = strtolower($parts[0]);

        switch ($command) {
            case 'add':
                if (isset($parts[1])) {
                    try {
                        $basket->add(new ProductCode(strtoupper($parts[1])));
                        echo "Added " . strtoupper($parts[1]) . " to basket\n";
                    } catch (Exception $e) {
                        echo "Error: " . $e->getMessage() . "\n";
                    }
                } else {
                    echo "Usage: add <product_code>\n";
                }
                break;

            case 'total':
                $subtotal = $basket->getSubtotal();
                $discounts = $basket->getDiscounts();
                $delivery = $basket->getDeliveryCharge();
                $total = $basket->total();

                echo "Subtotal: " . $subtotal->toFormattedString() . "\n";
                if ($discounts->toDollars() > 0) {
                    echo "Discounts: -" . $discounts->toFormattedString() . "\n";
                }
                echo "Delivery: " . $delivery->toFormattedString() . "\n";
                echo "Total: " . $total->toFormattedString() . "\n";
                break;

            case 'quit':
            case 'exit':
                echo "Goodbye!\n";
                return;

            default:
                echo "Unknown command. Available: add <code>, total, quit\n";
        }
    }
}

// Check command line arguments
if ($argc > 1 && $argv[1] === 'interactive') {
    runInteractiveMode();
} else {
    runBasketDemo();
}
