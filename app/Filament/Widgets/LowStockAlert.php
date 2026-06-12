<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockAlert extends BaseWidget
{
    protected static ?string $heading = 'Low Stock Alert (<= 5 units)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->where('stock', '<=', 5)
                    ->where('stock', '>', 0)
                    ->orderBy('stock', 'asc')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->weight('bold'),
                
                TextColumn::make('stock')
                    ->label('Stock Left')
                    ->badge()
                    ->color(fn($state): string => match(true) {
                        $state <= 2 => 'danger',
                        $state <= 5 => 'warning',
                        default => 'success',
                    })
                    ->formatStateUsing(fn($state): string => $state . ' units'),
                
                TextColumn::make('category.name')
                    ->label('Category'),
                
                TextColumn::make('price')
                    ->label('Price')
                    ->money('USD'),
            ]);
    }
}