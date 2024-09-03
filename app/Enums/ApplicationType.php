<?php

namespace App\Enums;

use App\Enums\Attributes\GetAttributes;
use App\Enums\Attributes\Title;

enum ApplicationType: string
{
    use GetAttributes;

    #[Title('Suggestion')]
    case SUGGESTION = 'suggestion';
    #[Title('Complaint')]
    case COMPLAINT = 'complaint';
    #[Title('Request')]
    case REQUEST = 'request';
}
