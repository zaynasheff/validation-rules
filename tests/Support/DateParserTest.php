<?php

declare(strict_types=1);

namespace Tests\Support;

use Carbon\Carbon;
use DateTime;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zaynasheff\ValidationRules\Support\DateParser;

final class DateParserTest extends TestCase
{
    private DateParser $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new DateParser;
    }

    #[Test]
    public function it_parses_carbon(): void
    {
        $date = Carbon::create(2000, 1, 1);

        $this->assertSame($date, $this->parser->parse($date));
    }

    #[Test]
    public function it_parses_datetime(): void
    {
        $result = $this->parser->parse(new DateTime('2000-01-01'));

        $this->assertInstanceOf(Carbon::class, $result);
        $this->assertSame('2000-01-01', $result->toDateString());
    }

    #[Test]
    public function it_parses_string(): void
    {
        $result = $this->parser->parse('2000-01-01');

        $this->assertInstanceOf(Carbon::class, $result);
        $this->assertSame('2000-01-01', $result->toDateString());
    }

    #[Test]
    public function it_returns_null_for_null(): void
    {
        $this->assertNull($this->parser->parse(null));
    }

    #[Test]
    public function it_returns_null_for_empty_string(): void
    {
        $this->assertNull($this->parser->parse(''));
    }

    #[Test]
    public function it_returns_null_for_invalid_string(): void
    {
        $this->assertNull($this->parser->parse('not-a-date'));
    }

    #[Test]
    public function it_returns_null_for_invalid_type(): void
    {
        $this->assertNull($this->parser->parse(12345));
        $this->assertNull($this->parser->parse([]));
        $this->assertNull($this->parser->parse(new \stdClass));
    }
}
