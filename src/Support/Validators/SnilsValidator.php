<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Support\Validators;

use Zaynasheff\ValidationRules\Enums\ValidationMessage;
use Zaynasheff\ValidationRules\Support\ValidationResult;

final class SnilsValidator
{
    public function validate(mixed $value): ValidationResult
    {
        if (! is_string($value)) {
            return ValidationResult::invalid(
                ValidationMessage::SNILS->value,
            );
        }

        $digits = preg_replace('/\D/', '', $value);

        if ($digits === null || strlen($digits) !== 11) {
            return ValidationResult::invalid(
                ValidationMessage::SNILS->value,
            );
        }

        $number = substr($digits, 0, 9);
        $checksum = (int) substr($digits, 9, 2);

        $sum = 0;

        foreach (str_split($number) as $index => $digit) {
            $sum += (int) $digit * (9 - $index);
        }

        $expected = match (true) {
            $sum < 100 => $sum,
            $sum === 100, $sum === 101 => 0,
            default => ($sum % 101 === 100) ? 0 : $sum % 101,
        };

        if ($checksum !== $expected) {
            return ValidationResult::invalid(
                ValidationMessage::SNILS->value,
            );
        }

        return ValidationResult::valid();
    }
}
