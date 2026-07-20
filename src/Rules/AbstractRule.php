<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Zaynasheff\ValidationRules\Support\ValidationResult;

abstract readonly class AbstractRule implements ValidationRule
{
    final public function validate(
        string $attribute,
        mixed $value,
        Closure $fail,
    ): void {
        $result = $this->validator($value);

        if ($result->valid) {
            return;
        }

        /** @var array<string, bool|float|int|string|null> $replace */
        $replace = $result->replace;

        $fail(__(
            $result->translationKey,
            $replace,
        ));
    }

    abstract protected function validator(mixed $value): ValidationResult;
}
