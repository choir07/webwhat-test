<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPosts extends BaseWidget
{
    protected static ?string $heading = 'Recent Posts';
    
    protected static ?int $sort = 5;
    
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->with(['author', 'category', 'featuredImage'])
                    ->latest('published_at')
                    ->limit(5)
            )
            ->columns([
                ImageColumn::make('featuredImage.url')
                    ->label('Image')
                    ->width(50)
                    ->imageHeight(50)
                    ->circular()
                    ->defaultImageUrl('https://via.placeholder.com/50x50?text=No+Image'),
                
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->weight('bold')
                    ->limit(40),
                
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('primary'),
                
                TextColumn::make('author.name')
                    ->label('Author'),
                
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                    
                
                TextColumn::make('published_at')
                    ->label('Published')
                    ->since(),
            ])
            ->defaultSort('published_at', 'desc');
    }
}