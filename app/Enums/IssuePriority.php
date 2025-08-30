<?php

declare(strict_types=1);

namespace App\Enums;

final class IssuePriority
{
    public const LOW = 'low';

    public const MEDIUM = 'medium';

    public const HIGH = 'high';

    public static function all(): array
    {
        return [
            self::LOW,
            self::MEDIUM,
            self::HIGH,
        ];
    }
}
