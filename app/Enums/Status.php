<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasColor, HasLabel
{
    // Post statuses
    case Draft      = 'draft';
    case Published  = 'published';
    case Archived   = 'archived';

    // Task/general statuses
    case Pending    = 'pending';
    case InProgress = 'in_progress';
    case Completed  = 'complete';

    public function getLabel(): string
    {
        return match($this) {
            self::Draft      => 'Draft',
            self::Published  => 'Published',
            self::Archived   => 'Archived',
            self::Pending    => 'Pending',
            self::InProgress => 'In Progress',
            self::Completed  => 'Completed',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::Draft      => 'gray',
            self::Published  => 'success',
            self::Archived   => 'danger',
            self::Pending    => 'warning',
            self::InProgress => 'info',
            self::Completed  => 'success',
        };
    }
}