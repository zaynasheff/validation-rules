<?php

declare(strict_types=1);

namespace Tests\Support\Validators;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zaynasheff\ValidationRules\Support\Validators\InnValidator;

final class InnValidatorTest extends TestCase
{
    private InnValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new InnValidator;
    }

    #[Test]
    public function it_validates_legal_entity_inn(): void
    {
        $result = $this->validator->validate('7707083893');

        $this->assertTrue($result->valid);
    }

    #[Test]
    public function it_validates_individual_inn(): void
    {
        $result = $this->validator->validate('500100732259');

        $this->assertTrue($result->valid);
    }

    #[Test]
    public function it_validates_formatted_inn(): void
    {
        $result = $this->validator->validate('770-708-3893');

        $this->assertTrue($result->valid);
    }

    #[Test]
    public function it_fails_when_legal_entity_checksum_is_invalid(): void
    {
        $result = $this->validator->validate('7707083894');

        $this->assertFalse($result->valid);
    }

    #[Test]
    public function it_fails_when_individual_checksum_is_invalid(): void
    {
        $result = $this->validator->validate('500100732258');

        $this->assertFalse($result->valid);
    }

    #[Test]
    public function it_fails_when_length_is_invalid(): void
    {
        $result = $this->validator->validate('123456789');

        $this->assertFalse($result->valid);
    }

    #[Test]
    public function it_fails_when_value_is_not_a_string(): void
    {
        $result = $this->validator->validate(7707083893);

        $this->assertFalse($result->valid);
    }

    #[Test]
    public function it_fails_when_value_is_empty(): void
    {
        $result = $this->validator->validate('');

        $this->assertFalse($result->valid);
    }
}
