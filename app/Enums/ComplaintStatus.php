<?php

namespace App\Enums;

enum ComplaintStatus: string
{
    case Pending = 'انتظار';
    case Checked = 'تم التحقق';
    case InProgress = 'يتم التنفيذ';
    case Completed = 'منجزة';
    case Rejected = 'مرفوضة';
    case Closed = 'مغلقة';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function isValid(string $status): bool
    {
        return in_array($status, self::values(), true);
    }
}
