<?php

declare(strict_types=1);

namespace Zaynasheff\ValidationRules\Enums;

enum ValidationMessage: string
{
    case INVALID_DATE = 'validation-rules::validation.invalid_date';

    case AGE_MIN = 'validation-rules::validation.age_min';

    case AGE_MAX = 'validation-rules::validation.age_max';

    case AGE_BETWEEN = 'validation-rules::validation.age_between';

    case SNILS = 'validation-rules::validation.snils';
}
