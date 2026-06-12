<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class SimpleStats extends Widget
{
    protected static string $view = 'filament.widgets.simple-stats';
    
    protected int | string | array $columnSpan = 'full';
    
    protected function getViewData(): array
    {
        return [
            'totalProducts' => \App\Models\Product::count(),
            'totalPosts' => \App\Models\Post::count(),
            'totalCategories' => \App\Models\Category::count(),
        ];
    }
}