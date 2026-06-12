<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Enums\ProductStatus;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsStats extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $totalValue = Product::sum('price');
        
        return [
            Stat::make('Total Products', Product::count())
                ->description('All products in catalog')
                ->color('success')
                ->icon('heroicon-o-shopping-bag'),
            
            Stat::make('Total Value', '$' . number_format($totalValue, 2))
                ->description('Inventory value')
                ->color('warning')
                ->icon('heroicon-o-banknotes'),
            
            Stat::make('Low Stock', Product::where('stock', '<=', 5)->where('stock', '>', 0)->count())
                ->description('Products needing restock')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle'),
            
            Stat::make('Out of Stock', Product::where('stock', 0)->count())
                ->description('No inventory left')
                ->color('danger')
                ->icon('heroicon-o-x-circle'),
            
            Stat::make('Published', Product::where('status', ProductStatus::PUBLISHED->value)->count())
                ->description('Active products')
                ->color('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}