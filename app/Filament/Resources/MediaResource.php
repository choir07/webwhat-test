<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages\ListMedia;
use App\Filament\Resources\MediaResource\Pages\ViewMedia;
use App\Filament\Resources\MediaResource\Pages\EditMedia;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

     protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Media Library';

    protected static string|\UnitEnum|null $navigationGroup =   'Content';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('File Name')
                    ->required()
                    ->maxLength(255),
                
                Textarea::make('custom_properties.description')
                    ->label('Description')
                    ->rows(3),
                
                Select::make('collection_name')
                    ->label('Collection')
                    ->options([
                        'products' => 'Products',
                        'posts' => 'Posts',
                        'avatars' => 'Avatars',
                        'general' => 'General',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('conversions.thumb')
                    ->label('Preview')
                    ->width(50)
                    ->height(50)
                    ->rounded(),
                
                TextColumn::make('file_name')
                    ->label('File Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(30),
                
                TextColumn::make('collection_name')
                    ->label('Collection')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'products' => 'success',
                        'posts' => 'info',
                        'avatars' => 'warning',
                        default => 'gray',
                    }),
                
                TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn($state) => self::formatBytes($state))
                    ->sortable(),
                
                TextColumn::make('mime_type')
                    ->label('Type')
                    ->badge()
                    ->color('primary')
                    ->limit(20),
                
                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('M d, Y')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchPlaceholder('Search media...')
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('File Details')
                    ->schema([
                        ImageEntry::make('conversions.large')
                            ->label('Preview')
                            ->columnSpanFull()
                            ->height(400)
                            ->width(600),
                        
                        TextEntry::make('file_name')
                            ->label('File Name'),
                        
                        TextEntry::make('collection_name')
                            ->label('Collection')
                            ->badge(),
                        
                        TextEntry::make('mime_type')
                            ->label('MIME Type'),
                        
                        TextEntry::make('size')
                            ->label('Size')
                            ->formatStateUsing(fn($state) => self::formatBytes($state)),
                        
                        TextEntry::make('custom_properties.description')
                            ->label('Description')
                            ->columnSpanFull(),
                        
                        TextEntry::make('created_at')
                            ->label('Uploaded At')
                            ->dateTime('F j, Y g:i A'),
                        
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('F j, Y g:i A'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMedia::route('/'),
            'view' => ViewMedia::route('/{record}'),
            'edit' => EditMedia::route('/{record}/edit'),
        ];
    }

    public static function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}