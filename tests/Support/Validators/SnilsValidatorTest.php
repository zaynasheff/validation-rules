<?php

declare(strict_types=1);

namespace Tests\Support\Validators;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zaynasheff\ValidationRules\Support\Validators\SnilsValidator;

final class SnilsValidatorTest extends TestCase
{
    private SnilsValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new SnilsValidator;
    }

    #[Test]
    public function it_accepts_valid_snils(): void
    {
        $result = $this->validator->validate('11223344595');

        $this->assertTrue($result->valid);
    }

    #[Test]
    public function it_accepts_formatted_snils(): void
    {
        $result = $this->validator->validate('112-233-445 95');

        $this->assertTrue($result->valid);
    }

    #[Test]
    public function it_rejects_invalid_checksum(): void
    {
        $result = $this->validator->validate('11223344596');

        $this->assertFalse($result->valid);

        $this->assertSame(
            'validation-rules::validation.snils',
            $result->translationKey,
        );
    }

    #[Test]
    public function it_rejects_invalid_length(): void
    {
        $result = $this->validator->validate('123');

        $this->assertFalse($result->valid);

        $this->assertSame(
            'validation-rules::validation.snils',
            $result->translationKey,
        );
    }

    #[Test]
    public function it_rejects_non_string_value(): void
    {
        $result = $this->validator->validate(12345678901);

        $this->assertFalse($result->valid);

        $this->assertSame(
            'validation-rules::validation.snils',
            $result->translationKey,
        );
    }

    #[Test]
    public function it_rejects_empty_string(): void
    {
        $result = $this->validator->validate('');

        $this->assertFalse($result->valid);

        $this->assertSame(
            'validation-rules::validation.snils',
            $result->translationKey,
        );
    }
}
