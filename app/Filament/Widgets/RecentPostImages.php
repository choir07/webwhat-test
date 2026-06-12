<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPostImages extends BaseWidget
{
    protected static ?string $heading = 'Recent Post Images';
    
    protected static ?int $sort = 6;
    
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->whereNotNull('featured_image')
                    ->orWhereNotNull('featured_image_id')
                    ->latest('created_at')
                    ->limit(6)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image_url')
                    ->label('Image')
                    ->width(80)
                    ->imageheight(80)
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Post Title')
                    ->searchable()
                    ->limit(40)
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->since(),
                
                // FIXED: Convert status to string properly
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => match (true) {
                        $state === 'published' || $state === 1 || (is_object($state) && method_exists($state, 'value') && $state->value === 'published') => 'Published',
                        $state === 'draft' || $state === 0 || (is_object($state) && method_exists($state, 'value') && $state->value === 'draft') => 'Draft',
                        default => 'Unknown',
                    })
                    ->color(fn ($state): string => match (true) {
                        $state === 'published' || $state === 1 || (is_object($state) && method_exists($state, 'value') && $state->value === 'published') => 'success',
                        $state === 'draft' || $state === 0 || (is_object($state) && method_exists($state, 'value') && $state->value === 'draft') => 'warning',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }
}