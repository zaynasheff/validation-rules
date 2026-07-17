<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTimeInterface;
use Throwable;

final class DateParser
{
    public function parse(mixed $value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value;
        }

        if ($value instanceof CarbonInterface) {
            return Carbon::instance($value);
        }

        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value);
        }

        if (! is_string($value)) {
            return null;
        }

        try {
            return Carbon::parse($value);
        } catch (Throwable) {
            return null;
        }
    }
}
