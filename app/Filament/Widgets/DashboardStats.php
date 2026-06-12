<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected function getStats(): array
    {
        return [
            Stat::make('Products', Product::count())
                ->description('Total products')
                ->color('success')
                ->icon('heroicon-o-shopping-bag'),
            
            Stat::make('Posts', Post::count())
                ->description('Total posts')
                ->color('info')
                ->icon('heroicon-o-document-text'),
            
            Stat::make('Categories', Category::count())
                ->description('Total categories')
                ->color('warning')
                ->icon('heroicon-o-tag'),
        ];
    }
}