<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class ProductsByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Products by Category';
    
    protected int | string | array $columnSpan = 1;
    protected function getData(): array
    {
        // Get all categories with their product counts
        $categories = Category::withCount('products')->get();
        
        // Filter out categories with 0 products
        $categories = $categories->filter(function($category) {
            return $category->products_count > 0;
        });
        
        $labels = $categories->pluck('name')->toArray();
        $data = $categories->pluck('products_count')->toArray();
        
        // Color palette for different categories
        $colors = ['#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4', '#14b8a6', '#f97316', '#6366f1'];
        
        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }
    
    protected function getType(): string
    {
        return 'doughnut';
    }
}