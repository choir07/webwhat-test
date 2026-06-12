<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ProductsChart extends ChartWidget
{
    protected ?string $heading = 'Products Created (Last 7 Days)';  // Remove 'static'
    
    protected int | string | array $columnSpan = 1;
    protected function getData(): array
    {
        $data = [];
        $labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $labels[] = $date->format('D, M j');
            $count = Product::whereDate('created_at', $date)->count();
            $data[] = $count;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Products Created',
                    'data' => $data,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.2)',
                    'borderColor' => '#f59e0b',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
}