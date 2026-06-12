<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Spatie\Activitylog\Models\Activity;

class RecentActivity extends BaseWidget
{
    protected static ?string $heading = 'Recent Activity';

    protected static ?int $sort = 6;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Activity::query()
                    ->with('causer')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime('H:i:s')
                    ->since()
                    ->sortable(),

                TextColumn::make('log_name')
                    ->label('Type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'User Management' => 'primary',
                        'Content Management' => 'success',
                        'Authentication' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('description')
                    ->label('Action')
                    ->searchable()
                    ->limit(40),

                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->weight('bold'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}