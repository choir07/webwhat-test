<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('featuredImage.url')
                    ->label('Featured Image')
                    ->imageHeight(300)
                    ->columnSpanFull()
                    ->visible(fn($record) => $record->featured_image_id !== null),

                TextEntry::make('title'),

                TextEntry::make('description')
                    ->columnSpanFull(),

                TextEntry::make('status')
                    ->badge(),

                TextEntry::make('priority')
                    ->badge(),

                TextEntry::make('category.name')
                    ->label('Category')
                    ->badge(),

                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('featuredImage.url')
                    ->label('Image URL Debug'),
                    
            ]);
    }
}