<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\File;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),

                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),

                Select::make('status')
                    ->options(Status::class)
                    ->required(),

                Select::make('priority')
                    ->options(Priority::class)
                    ->required(),

                //  Featured image from Media Library
                Select::make('featured_image_id')
                    ->label('Featured Image')
                    ->options(fn() => File::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->nullable()
                    ->placeholder('Select from Media Library')
                    ->helperText('Upload images in Media Library first'),

                //  Image gallery repeater
                Repeater::make('postImages')
                    ->relationship('postImages')
                    ->label('Image Gallery')
                    ->schema([
                        Select::make('file_id')
                            ->label('Image')
                            ->options(fn() => File::pluck('name', 'id')->toArray())
                            ->searchable()
                            ->required()
                            ->helperText('Select from Media Library'),

                        TextInput::make('caption')
                            ->label('Caption')
                            ->maxLength(255),

                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2)
                    ->defaultItems(0)
                    ->collapsible()
                    ->reorderableWithDragAndDrop()
                    ->itemLabel(fn(array $state): ?string => $state['caption'] ?: 'Image')
                    ->columnSpanFull(),
            ]);
    }
}