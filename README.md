# Validation Rules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/zaynasheff/validation-rules.svg?style=flat-square)](https://packagist.org/packages/zaynasheff/validation-rules)
[![PHP Version](https://img.shields.io/packagist/php-v/zaynasheff/validation-rules?style=flat-square)](https://packagist.org/packages/zaynasheff/validation-rules)
[![License](https://img.shields.io/github/license/zaynasheff/validation-rules?style=flat-square)](LICENSE)

A collection of reusable Laravel validation rules for Russian documents and business identifiers.

Currently supported:

- ✅ Age
- ✅ SNILS
- ✅ INN

---

## Features

- Laravel native validation rules
- Full Laravel localization support
- English and Russian translations
- PHPUnit tested
- PHPStan compatible
- Laravel 13+
- PHP 8.4+

---

## Requirements

- PHP 8.2+
- illuminate/support 10.0+

---

## Installation

```bash
composer require zaynasheff/validation-rules
```

---

## Usage

### Age

```php
use Zaynasheff\ValidationRules\Rules\Age;

$request->validate([
    'birth_date' => [
        'required',
        new Age(min: 18),
    ],
]);
```

Between:

```php
new Age(min: 18, max: 65)
```

---

### SNILS

```php
use Zaynasheff\ValidationRules\Rules\Snils;

$request->validate([
    'snils' => [
        'required',
        new Snils(),
    ],
]);
```

Accepted formats:

```
11223344595
112-233-445 95
```

---

### INN

```php
use Zaynasheff\ValidationRules\Rules\Inn;

$request->validate([
    'inn' => [
        'required',
        new Inn(),
    ],
]);
```

Supports:

- Individual INN (12 digits)
- Legal entity INN (10 digits)

---

## Localization

Package includes translations for:

- English
- Russian

Laravel localization works automatically.

---

## Testing

```bash
composer test
```

Run static analysis:

```bash
composer analyse
```

Run formatter:

```bash
composer format
```

Run all checks:

```bash
composer fix
```

---

## Contributing

Pull requests are welcome.

Please ensure that all tests and static analysis pass before submitting changes.

---

## License

The MIT License (MIT).