<?php

declare(strict_types=1);

namespace Tests\Rules;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zaynasheff\ValidationRules\Rules\Age;

final class AgeTest extends TestCase
{
    #[Test]
    public function it_passes_validation(): void
    {
        $validator = Validator::make(
            [
                'birthday' => '2000-01-01',
            ],
            [
                'birthday' => [
                    new Age(
                        min: 18,
                        at: Carbon::parse('2025-01-01'),
                    ),
                ],
            ],
        );

        $this->assertTrue($validator->passes());
    }

    #[Test]
    public function it_fails_when_age_is_less_than_minimum(): void
    {
        $validator = Validator::make(
            [
                'birthday' => '2010-01-01',
            ],
            [
                'birthday' => [
                    new Age(
                        min: 18,
                        at: Carbon::parse('2025-01-01'),
                    ),
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The birthday must be at least 18 years old.',
            $validator->errors()->first('birthday'),
        );
    }

    #[Test]
    public function it_fails_when_age_is_greater_than_maximum(): void
    {
        $validator = Validator::make(
            [
                'birthday' => '1950-01-01',
            ],
            [
                'birthday' => [
                    new Age(
                        max: 65,
                        at: Carbon::parse('2025-01-01'),
                    ),
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The birthday must not be older than 65 years.',
            $validator->errors()->first('birthday'),
        );
    }

    #[Test]
    public function it_fails_when_age_is_outside_range(): void
    {
        $validator = Validator::make(
            [
                'birthday' => '2015-01-01',
            ],
            [
                'birthday' => [
                    new Age(
                        min: 18,
                        max: 65,
                        at: Carbon::parse('2025-01-01'),
                    ),
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The birthday must be between 18 and 65 years old.',
            $validator->errors()->first('birthday'),
        );
    }

    #[Test]
    public function it_fails_when_date_is_invalid(): void
    {
        $validator = Validator::make(
            [
                'birthday' => 'invalid-date',
            ],
            [
                'birthday' => [
                    new Age(min: 18),
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The birthday must be a valid date.',
            $validator->errors()->first('birthday'),
        );
    }
}
