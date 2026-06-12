<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostAnalytics extends BaseWidget
{
    protected static ?string $pollingInterval = '60s';
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Posts', Post::count())
                ->description('All time posts')
                ->icon('heroicon-o-document-text')
                ->color('success'),
            
            Stat::make('Published Posts', Post::where('status', 'published')->count())
                ->description('Live on site')
                ->icon('heroicon-o-check-circle')
                ->color('info'),
            
            Stat::make('Total Views', Post::sum('views'))
                ->description('All time views')
                ->icon('heroicon-o-eye')
                ->color('warning'),
            
            Stat::make('Most Popular', Post::max('views') . ' views')
                ->description(Post::orderBy('views', 'desc')->first()?->title ?? 'None')
                ->icon('heroicon-o-fire')
                ->color('danger'),
        ];
    }
}