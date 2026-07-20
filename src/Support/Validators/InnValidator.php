<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Support\Validators;

use Zaynasheff\ValidationRules\Enums\ValidationMessage;
use Zaynasheff\ValidationRules\Support\ValidationResult;

final readonly class InnValidator
{
    public function validate(mixed $value): ValidationResult
    {
        if (! is_string($value)) {
            return ValidationResult::invalid(
                ValidationMessage::INN->value,
            );
        }

        $inn = preg_replace('/\D/', '', $value);

        if ($inn === null) {
            return ValidationResult::invalid(
                ValidationMessage::INN->value,
            );
        }

        if (strlen($inn) === 10) {
            return $this->validateLegalEntity($inn);
        }

        if (strlen($inn) === 12) {
            return $this->validateIndividual($inn);
        }

        return ValidationResult::invalid(
            ValidationMessage::INN->value,
        );
    }

    private function validateLegalEntity(string $inn): ValidationResult
    {
        $checksum = $this->calculateChecksum(
            $inn,
            [2, 4, 10, 3, 5, 9, 4, 6, 8],
        );

        if ($checksum !== (int) $inn[9]) {
            return ValidationResult::invalid(
                ValidationMessage::INN->value,
            );
        }

        return ValidationResult::valid();
    }

    private function validateIndividual(string $inn): ValidationResult
    {
        $firstChecksum = $this->calculateChecksum(
            $inn,
            [7, 2, 4, 10, 3, 5, 9, 4, 6, 8],
        );

        if ($firstChecksum !== (int) $inn[10]) {
            return ValidationResult::invalid(
                ValidationMessage::INN->value,
            );
        }

        $secondChecksum = $this->calculateChecksum(
            $inn,
            [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8],
        );

        if ($secondChecksum !== (int) $inn[11]) {
            return ValidationResult::invalid(
                ValidationMessage::INN->value,
            );
        }

        return ValidationResult::valid();
    }

    /**
     * @param  array<int>  $coefficients
     */
    private function calculateChecksum(string $inn, array $coefficients): int
    {
        $sum = 0;

        foreach ($coefficients as $index => $coefficient) {
            $sum += (int) $inn[$index] * $coefficient;
        }

        return ($sum % 11) % 10;
    }
}
