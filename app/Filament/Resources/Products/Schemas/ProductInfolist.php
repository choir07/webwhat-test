<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\ProductStatus;
use Filament\Schema\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Product Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Product Name')
                            ->size('lg')
                            ->weight('bold'),
                        
                        TextEntry::make('sku')
                            ->label('SKU')
                            ->badge()
                            ->color('info'),
                        
                        TextEntry::make('price')
                            ->label('Price')
                            ->formatStateUsing(fn($state) => '$' . number_format($state, 2))
                            ->size('lg'),
                        
                        TextEntry::make('stock')
                            ->label('Stock Quantity')
                            ->badge()
                            ->color(fn($state) => $state <= 5 ? 'danger' : ($state <= 10 ? 'warning' : 'success'))
                            ->formatStateUsing(fn($state) => $state . ' units'),
                        
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull()
                            ->markdown(),
                        
                        TextEntry::make('category.name')
                            ->label('Category')
                            ->badge()
                            ->color('primary'),
                        
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state?->getLabel() ?? $state)
                            ->color(fn($state) => $state?->getColor() ?? 'gray'),
                        
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime()
                            ->since(),
                        
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime()
                            ->since(),
                    ])
                    ->columns(2),
            ]);
    }
}