<?php

declare(strict_types=1);

namespace Tests\Rules;

use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zaynasheff\ValidationRules\Rules\Inn;

final class InnTest extends TestCase
{
    #[Test]
    public function it_passes_with_valid_legal_entity_inn(): void
    {
        $validator = Validator::make(
            [
                'inn' => '7707083893',
            ],
            [
                'inn' => [
                    new Inn,
                ],
            ],
        );

        $this->assertTrue($validator->passes());
    }

    #[Test]
    public function it_passes_with_valid_individual_inn(): void
    {
        $validator = Validator::make(
            [
                'inn' => '500100732259',
            ],
            [
                'inn' => [
                    new Inn,
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
                'inn' => '7707083894',
            ],
            [
                'inn' => [
                    new Inn,
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The inn must be a valid INN.',
            $validator->errors()->first('inn'),
        );
    }

    #[Test]
    public function it_fails_when_length_is_invalid(): void
    {
        $validator = Validator::make(
            [
                'inn' => '123456789',
            ],
            [
                'inn' => [
                    new Inn,
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The inn must be a valid INN.',
            $validator->errors()->first('inn'),
        );
    }

    #[Test]
    public function it_passes_when_value_is_empty(): void
    {
        $validator = Validator::make(
            [
                'inn' => '',
            ],
            [
                'inn' => [
                    new Inn,
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
                'inn' => '',
            ],
            [
                'inn' => [
                    'required',
                    new Inn,
                ],
            ],
        );

        $this->assertTrue($validator->fails());
    }

    #[Test]
    public function it_fails_when_value_is_not_valid(): void
    {
        $validator = Validator::make(
            [
                'inn' => 'abcdefghijk',
            ],
            [
                'inn' => [
                    new Inn,
                ],
            ],
        );

        $this->assertTrue($validator->fails());

        $this->assertSame(
            'The inn must be a valid INN.',
            $validator->errors()->first('inn'),
        );
    }
}
