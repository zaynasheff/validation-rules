<?php

declare(strict_types=1);

namespace Tests\Rules;

use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zaynasheff\ValidationRules\Rules\Snils;

final class SnilsTest extends TestCase
{
    #[Test]
    public function it_passes_validation(): void
    {
        $validator = Validator::make(
            [
                'snils' => '112-233-445 95',
            ],
            [
                'snils' => [
                    new Snils,
                ],
            ],
        );

        $this->assertTrue($validator->passes());
    }

    #[Test]
    public function it_fails_when_checksum_is_invalid(): void
    {
        $validator = Validator::make(
            [
                'snils' => '112-233-445 96',
            ],
            [
                'snils' => [
                    new Snils,
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The snils must be a valid SNILS number.',
            $validator->errors()->first('snils'),
        );
    }

    #[Test]
    public function it_fails_when_length_is_invalid(): void
    {
        $validator = Validator::make(
            [
                'snils' => '123',
            ],
            [
                'snils' => [
                    new Snils,
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The snils must be a valid SNILS number.',
            $validator->errors()->first('snils'),
        );
    }

    #[Test]
    public function it_passes_when_value_is_empty(): void
    {
        $validator = Validator::make(
            [
                'snils' => '',
            ],
            [
                'snils' => [
                    new Snils,
                ],
            ],
        );

        $this->assertTrue($validator->passes());
    }

    #[Test]
    public function it_fails_when_required_and_value_is_empty(): void
    {
        $validator = Validator::make(
            [
                'snils' => '',
            ],
            [
                'snils' => [
                    'required',
                    new Snils,
                ],
            ],
        );

        $this->assertTrue($validator->fails());
    }
}
