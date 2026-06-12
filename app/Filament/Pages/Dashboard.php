<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = "Dashboard";
    
    protected static ?int $navigationSort = -2;
    
    // Fix: Return type must be int|array (not int|string|array)
    public function getColumns(): int|array
    {
        return 2;  // Use integer for column count
    }
}