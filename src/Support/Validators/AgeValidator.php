<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Support\Validators;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Zaynasheff\ValidationRules\Enums\ValidationMessage;
use Zaynasheff\ValidationRules\Support\DateParser;
use Zaynasheff\ValidationRules\Support\ValidationResult;

final readonly class AgeValidator
{
    public function __construct(
        private DateParser $dateParser = new DateParser,
    ) {}

    public function validate(
        mixed $value,
        ?int $min = null,
        ?int $max = null,
        CarbonInterface|string|null $at = null,
    ): ValidationResult {
        $date = $this->dateParser->parse($value);

        if ($date === null) {
            return ValidationResult::invalid(
                ValidationMessage::INVALID_DATE->value,
            );
        }

        $referenceDate = $this->resolveReferenceDate($at);

        $age = $date->diffInYears($referenceDate);

        if ($min !== null && $max !== null && ($age < $min || $age > $max)) {
            return ValidationResult::invalid(
                ValidationMessage::AGE_BETWEEN->value,
                [
                    'min' => $min,
                    'max' => $max,
                ],
            );
        }

        if ($min !== null && $age < $min) {
            return ValidationResult::invalid(
                ValidationMessage::AGE_MIN->value,
                [
                    'min' => $min,
                ],
            );
        }

        if ($max !== null && $age > $max) {
            return ValidationResult::invalid(
                ValidationMessage::AGE_MAX->value,
                [
                    'max' => $max,
                ],
            );
        }

        return ValidationResult::valid();
    }

    private function resolveReferenceDate(
        CarbonInterface|string|null $at,
    ): Carbon {
        if ($at === null) {
            return Carbon::today();
        }

        if ($at instanceof CarbonInterface) {
            return Carbon::instance($at);
        }

        return Carbon::parse($at);
    }
}
