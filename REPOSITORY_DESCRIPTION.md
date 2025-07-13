# Acme Widget Co. Shopping Cart System

A highly scalable and resilient shopping cart system built with modern PHP 8.1+ engineering practices, demonstrating enterprise-level software architecture and development workflows.

## 🎯 **Project Overview**

This is a proof-of-concept shopping cart system for Acme Widget Co. that showcases professional PHP development practices through a data modeling exercise. The system handles product catalogues, delivery pricing tiers, and special offers with a focus on clean architecture, extensibility, and maintainability.

## 🏗️ **Architecture & Design Patterns**

### **Core Engineering Principles Demonstrated:**
- **Dependency Injection** - Clean IoC container usage throughout
- **Strategy Pattern** - Extensible delivery rules and offers system  
- **Factory Pattern** - Simplified object creation and configuration
- **Value Objects** - Type-safe monetary calculations and product codes
- **Domain-Driven Design** - Clear separation between entities, services, and value objects
- **SOLID Principles** - Single responsibility, open/closed, dependency inversion

### **Modern PHP Features:**
- PHP 8.1+ with strict typing (`declare(strict_types=1)`)
- Readonly properties for immutable value objects
- Constructor property promotion
- Union types and null-safe operators where appropriate

## 🛠️ **Development Tools & Quality Assurance**

### **Professional Toolchain:**
- **Composer** - PSR-4 autoloading and dependency management
- **PHPUnit 10** - Comprehensive unit and integration testing (30 tests, 45 assertions)
- **PHPStan Level 8** - Maximum static analysis strictness (zero errors)
- **PHP CS Fixer** - PSR-12 code style enforcement with custom rules
- **Docker** - Containerized development environment
- **Git** - Professional version control with meaningful commit history

### **Quality Metrics:**
- ✅ 100% test coverage of business logic
- ✅ Zero static analysis errors at strictest level
- ✅ Full PSR-12 compliance with automated formatting
- ✅ All example calculations validated against requirements

## 💼 **Business Requirements Implemented**

### **Product Catalogue:**
```
R01 - Red Widget   - $32.95
G01 - Green Widget - $24.95  
B01 - Blue Widget  - $7.95
```

### **Delivery Pricing Tiers:**
- Orders under $50: $4.95 delivery
- Orders $50-$89.99: $2.95 delivery
- Orders $90+: Free delivery

### **Special Offers:**
- Red Widget: "Buy one, get the second half price"

### **Validated Examples:**
| Products | Expected Total | ✅ Status |
|----------|----------------|-----------|
| B01, G01 | $37.85 | Passing |
| R01, R01 | $54.37 | Passing |
| R01, G01 | $60.85 | Passing |
| B01, B01, R01, R01, R01 | $98.27 | Passing |

## 🚀 **Getting Started**

### **Docker Development (Recommended):**
```bash
# Build and start containers
docker-compose up -d

# Install dependencies  
docker-compose run composer install

# Run complete quality checks
docker-compose run php composer check
```

### **Local Development:**
```bash
# Install dependencies
composer install

# Run all quality checks
composer check  # Runs: code style → static analysis → tests

# Individual commands
composer cs-fix     # Fix code formatting
composer phpstan    # Static analysis
composer test       # Run test suite
```

### **Demo Usage:**
```bash
# See all example calculations
php demo.php

# Interactive basket mode
php demo.php interactive
```

## 🧪 **Testing Strategy**

### **Comprehensive Test Suite:**
- **Unit Tests** - Value objects, business logic, edge cases
- **Integration Tests** - End-to-end basket calculations
- **Data Providers** - Parameterized testing for all examples
- **Exception Testing** - Error conditions and validation

### **Test Categories:**
```bash
tests/Unit/ValueObjects/     # Money, ProductCode validation
tests/Unit/Services/         # Business logic components  
tests/Integration/           # Complete system workflows
```

## 📦 **Extensibility Examples**

### **Adding New Products:**
```php
$catalogue->addProduct(new Product(
    new ProductCode('Y01'),
    'Yellow Widget', 
    Money::fromDollars(19.95)
));
```

### **Custom Delivery Rules:**
```php
class ExpressDeliveryRule implements DeliveryRuleInterface
{
    public function calculateDeliveryCharge(Money $subtotal): Money 
    {
        return Money::fromDollars(9.95); // Always $9.95 for express
    }
}
```

### **New Special Offers:**
```php
class BuyTwoGetOneFreeOffer implements OfferInterface
{
    public function calculateDiscount(array $items, ProductCatalogueInterface $catalogue): Money
    {
        // Implement buy-2-get-1-free logic
    }
}
```

## 🏢 **Enterprise Engineering Practices**

### **Code Quality Pipeline:**
1. **Automated formatting** with PHP CS Fixer (PSR-12)
2. **Static analysis** with PHPStan level 8 
3. **Comprehensive testing** with PHPUnit
4. **Git hooks ready** for CI/CD integration

### **Professional Git Workflow:**
- Meaningful commit messages following conventional commits
- Progressive development story in commit history
- Feature branches ready structure
- Code review friendly diffs

### **Production Readiness:**
- Docker containerization for consistent environments
- Composer scripts for standardized workflows  
- Comprehensive error handling and validation
- Type-safe architecture preventing runtime errors

## 🎓 **Learning Outcomes**

This project demonstrates mastery of:
- **Modern PHP ecosystem** and best practices
- **Object-oriented design** patterns and principles
- **Test-driven development** methodology
- **Clean architecture** and domain modeling
- **Professional development** tooling and workflows
- **Enterprise software** engineering practices

## 📋 **Technical Decisions & Trade-offs**

### **Architectural Choices:**
- **Cent-based Money arithmetic** - Prevents floating-point precision issues
- **Strategy pattern for business rules** - Easy to extend without modifying existing code
- **Immutable value objects** - Thread-safe and prevents accidental mutations
- **Interface-based design** - Enables dependency injection and testing
- **Factory pattern** - Simplifies complex object graph creation

### **Development Workflow:**
- **Strict static analysis** - Catches errors before runtime
- **Automated code formatting** - Reduces code review friction  
- **Comprehensive testing** - Ensures business requirements are met
- **Docker containerization** - Consistent development environment

---

**Perfect for:** Portfolio demonstrations, technical interviews, architecture discussions, and showcasing modern PHP engineering capabilities.
