<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Rules;

use Zaynasheff\ValidationRules\Support\ValidationResult;
use Zaynasheff\ValidationRules\Support\Validators\InnValidator;

final readonly class Inn extends AbstractRule
{
    protected function validator(mixed $value): ValidationResult
    {
        return app(InnValidator::class)->validate($value);
    }
}
