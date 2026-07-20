<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Support;

final readonly class ValidationResult
{
    /**
     * @param  array<string, bool|float|int|string|null>  $replace
     */
    public function __construct(
        public bool $valid,
        public ?string $translationKey = null,

        /** @var array<string, bool|float|int|string|null> */
        public array $replace = [],
    ) {}

    public static function valid(): self
    {
        return new self(valid: true);
    }

    /**
     * @param  array<string, bool|float|int|string|null>  $replace
     */
    public static function invalid(
        string $translationKey,
        array $replace = [],
    ): self {
        return new self(
            valid: false,
            translationKey: $translationKey,
            replace: $replace,
        );
    }
}
