<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentProductsTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Products';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->with(['category', 'image'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                ImageColumn::make('image.path')
                    ->label('Image')
                    ->width(50)
                    ->imageHeight(50)
                    ->circular(),
                
                TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->weight('bold'),
                
                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),
                
                TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable(),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(Product $record): string => match ($record->status->value) 
                    {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
                
                TextColumn::make('created_at')
                    ->label('Added')
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}