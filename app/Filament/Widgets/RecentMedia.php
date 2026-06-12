<?php

namespace App\Filament\Widgets;

use App\Models\File;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentMedia extends BaseWidget
{
    protected static ?string $heading = 'Recent Uploads';

    protected static ?int $sort = 7;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                File::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                ImageColumn::make('path')
                    ->label('Preview')
                    ->width(50)
                    ->height(50)
                    ->rounded(),
                
                TextColumn::make('name')
                    ->label('File Name')
                    ->limit(30)
                    ->searchable()
                    ->weight('bold'),
                
                TextColumn::make('collection')
                    ->label('Collection')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'products' => 'success',
                        'posts' => 'info',
                        'avatars' => 'warning',
                        default => 'gray',
                    }),
                
                TextColumn::make('size_formatted')
                    ->label('Size'),
                
                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}