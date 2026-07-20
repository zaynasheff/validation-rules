<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Rules;

use Carbon\CarbonInterface;
use Zaynasheff\ValidationRules\Support\ValidationResult;
use Zaynasheff\ValidationRules\Support\Validators\AgeValidator;

final readonly class Age extends AbstractRule
{
    public function __construct(
        private ?int $min = null,
        private ?int $max = null,
        private CarbonInterface|string|null $at = null,
    ) {}

    protected function validator(mixed $value): ValidationResult
    {
        return app(AgeValidator::class)->validate(
            value: $value,
            min: $this->min,
            max: $this->max,
            at: $this->at,
        );
    }
}
