<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Rules;

use Zaynasheff\ValidationRules\Support\ValidationResult;
use Zaynasheff\ValidationRules\Support\Validators\SnilsValidator;

final readonly class Snils extends AbstractRule
{
    protected function validator(mixed $value): ValidationResult
    {
        return app(SnilsValidator::class)->validate($value);
    }
}
