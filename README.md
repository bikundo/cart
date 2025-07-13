# Acme Widget Co. Basket System

A highly scalable and resilient shopping basket system built with modern PHP practices, demonstrating enterprise-level engineering principles.

## Architecture & Design Patterns

This system showcases several key engineering principles:

- **Dependency Injection**: The `Basket` class accepts its dependencies through constructor injection
- **Strategy Pattern**: Delivery rules and offers are implemented as interchangeable strategies
- **Value Objects**: `Money` and `ProductCode` ensure type safety and encapsulation
- **Factory Pattern**: `BasketFactory` provides easy system configuration
- **Strong Typing**: Leverages PHP 8.1+ strict types and readonly properties
- **SOLID Principles**: Clear separation of concerns with single responsibility classes

## Key Features

- ✅ Type-safe money calculations with precise cent-based arithmetic
- ✅ Extensible offer system using Strategy pattern
- ✅ Configurable delivery rules
- ✅ Comprehensive unit and integration test coverage
- ✅ PHPStan level 8 static analysis
- ✅ Docker containerized development environment
- ✅ PSR-4 autoloading with Composer

## Requirements

- PHP 8.1+
- Docker & Docker Compose (for containerized development)

## Installation

### Using Docker (Recommended)

```bash
# Build and start containers
docker-compose up -d

# Install dependencies
docker-compose run composer install

# Run tests
docker-compose run phpunit

# Run static analysis
docker-compose run phpstan analyse
```

### Local Development

```bash
# Install dependencies
composer install

# Run tests
composer test

# Run static analysis
composer phpstan

# Run all checks
composer check
```

## Usage

### Command Line Demo

```bash
# Run example calculations
php demo.php

# Interactive mode
php demo.php interactive
```

### Programmatic Usage

```php
use Acme\Cart\Factory\BasketFactory;
use Acme\Cart\ValueObjects\ProductCode;

$basket = BasketFactory::createWithDefaultConfiguration();

$basket->add(new ProductCode('R01'));
$basket->add(new ProductCode('R01'));

echo $basket->total()->toFormattedString(); // $54.37
```

## Product Catalogue

| Code | Product     | Price  |
|------|-------------|--------|
| R01  | Red Widget  | $32.95 |
| G01  | Green Widget| $24.95 |
| B01  | Blue Widget | $7.95  |

## Delivery Rules

- Orders under $50: $4.95 delivery
- Orders $50-$89.99: $2.95 delivery  
- Orders $90+: Free delivery

## Current Offers

- **Red Widget Special**: Buy one red widget, get the second half price

## Example Calculations

| Products | Expected Total |
|----------|----------------|
| B01, G01 | $37.85 |
| R01, R01 | $54.37 |
| R01, G01 | $60.85 |
| B01, B01, R01, R01, R01 | $98.27 |

## Testing

The system includes comprehensive test coverage:

```bash
# Run all tests
composer test

# Run with coverage
composer test-coverage
```

Tests include:
- Unit tests for all value objects and services
- Integration tests validating complete basket calculations
- Edge case testing for business rules

## Architecture Decisions

### Money Value Object
- Uses cent-based integer arithmetic to avoid floating-point precision issues
- Immutable design prevents accidental mutations
- Rich API for mathematical operations and comparisons

### Strategy Pattern for Business Rules
- Delivery rules and offers are easily extensible
- New offers can be added without modifying existing code
- Follows Open/Closed Principle

### Dependency Injection
- Makes the system highly testable
- Allows for easy configuration and extension
- Reduces coupling between components

### Type Safety
- Leverages PHP 8.1+ features like readonly properties
- Strong typing prevents common bugs
- PHPStan ensures static type safety

## Extending the System

### Adding New Products

```php
$catalogue->addProduct(new Product(
    new ProductCode('Y01'),
    'Yellow Widget',
    Money::fromDollars(19.95)
));
```

### Adding New Offers

```php
class NewSpecialOffer implements OfferInterface
{
    public function calculateDiscount(array $items, ProductCatalogueInterface $catalogue): Money
    {
        // Implement offer logic
    }
    
    public function getDescription(): string
    {
        return 'New special offer description';
    }
}
```

### Custom Delivery Rules

```php
class CustomDeliveryRule implements DeliveryRuleInterface
{
    public function calculateDeliveryCharge(Money $subtotal): Money
    {
        // Implement custom delivery logic
    }
}
```

## Development Tools

- **PHPUnit**: Unit and integration testing
- **PHPStan**: Static analysis at level 8
- **Docker**: Containerized development environment
- **Composer**: Dependency management and autoloading

## Assumptions

1. All monetary calculations use USD currency
2. Product codes are case-sensitive
3. Offers apply before delivery charge calculation
4. Multiple identical offers do not stack
5. Delivery charges are calculated on post-discount subtotal
