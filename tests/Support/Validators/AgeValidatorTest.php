<?php

declare(strict_types=1);

namespace Tests\Support\Validators;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zaynasheff\ValidationRules\Enums\ValidationMessage;
use Zaynasheff\ValidationRules\Support\Validators\AgeValidator;

final class AgeValidatorTest extends TestCase
{
    #[Test]
    public function it_validates_minimum_age(): void
    {
        $result = (new AgeValidator)->validate(
            value: '2000-01-01',
            min: 18,
            at: Carbon::parse('2025-01-01'),
        );

        $this->assertTrue($result->valid);
        $this->assertNull($result->translationKey);
        $this->assertSame([], $result->replace);
    }

    #[Test]
    public function it_fails_when_age_is_less_than_minimum(): void
    {
        $result = (new AgeValidator)->validate(
            value: '2010-01-01',
            min: 18,
            at: Carbon::parse('2025-01-01'),
        );

        $this->assertFalse($result->valid);
        $this->assertSame(
            ValidationMessage::AGE_MIN->value,
            $result->translationKey,
        );
        $this->assertSame(
            ['min' => 18],
            $result->replace,
        );
    }

    #[Test]
    public function it_validates_maximum_age(): void
    {
        $result = (new AgeValidator)->validate(
            value: '1980-01-01',
            max: 65,
            at: Carbon::parse('2025-01-01'),
        );

        $this->assertTrue($result->valid);
    }

    #[Test]
    public function it_fails_when_age_is_greater_than_maximum(): void
    {
        $result = (new AgeValidator)->validate(
            value: '1950-01-01',
            max: 65,
            at: Carbon::parse('2025-01-01'),
        );

        $this->assertFalse($result->valid);
        $this->assertSame(
            ValidationMessage::AGE_MAX->value,
            $result->translationKey,
        );
        $this->assertSame(
            ['max' => 65],
            $result->replace,
        );
    }

    #[Test]
    public function it_validates_age_between(): void
    {
        $result = (new AgeValidator)->validate(
            value: '1990-01-01',
            min: 18,
            max: 65,
            at: Carbon::parse('2025-01-01'),
        );

        $this->assertTrue($result->valid);
    }

    #[Test]
    public function it_fails_when_age_is_less_than_range(): void
    {
        $result = (new AgeValidator)->validate(
            value: '2015-01-01',
            min: 18,
            max: 65,
            at: Carbon::parse('2025-01-01'),
        );

        $this->assertFalse($result->valid);
        $this->assertSame(
            ValidationMessage::AGE_BETWEEN->value,
            $result->translationKey,
        );
        $this->assertSame(
            [
                'min' => 18,
                'max' => 65,
            ],
            $result->replace,
        );
    }

    #[Test]
    public function it_fails_when_age_is_greater_than_range(): void
    {
        $result = (new AgeValidator)->validate(
            value: '1950-01-01',
            min: 18,
            max: 65,
            at: Carbon::parse('2025-01-01'),
        );

        $this->assertFalse($result->valid);
        $this->assertSame(
            ValidationMessage::AGE_BETWEEN->value,
            $result->translationKey,
        );
        $this->assertSame(
            [
                'min' => 18,
                'max' => 65,
            ],
            $result->replace,
        );
    }

    #[Test]
    public function it_fails_for_invalid_date(): void
    {
        $result = (new AgeValidator)->validate(
            value: 'invalid-date',
            min: 18,
        );

        $this->assertFalse($result->valid);
        $this->assertSame(
            ValidationMessage::INVALID_DATE->value,
            $result->translationKey,
        );
        $this->assertSame([], $result->replace);
    }
}
