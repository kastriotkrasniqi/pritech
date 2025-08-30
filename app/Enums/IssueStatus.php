<?php

declare(strict_types=1);

namespace App\Enums;

final class IssueStatus
{
    public const OPEN = 'open';

    public const IN_PROGRESS = 'in_progress';

    public const CLOSED = 'closed';

    public static function all(): array
    {
        return [
            self::OPEN,
            self::IN_PROGRESS,
            self::CLOSED,
        ];
    }
}
