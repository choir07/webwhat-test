<?php

namespace App\Filament\Widgets;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Ideas', Post::count())
                ->description('All ideas in vault')
                ->color('primary'),
            
            Stat::make('High Priority', Post::where('priority', Priority::High->value)->count())
                ->description('Needs attention')
                ->color(Priority::High->getColor()),
            
            Stat::make('In Progress', Post::where('status', Status::InProgress->value)->count())
                ->description('Currently being worked on')
                ->color(Status::InProgress->getColor()),
            
            Stat::make('Completed', Post::where('status', Status::Completed->value)->count())
                ->description('Finished ideas')
                ->color(Status::Completed->getColor()),
        ];
    }
}
