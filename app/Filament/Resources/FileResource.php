<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages\CreateFile;
use App\Filament\Resources\FileResource\Pages\EditFile;
use App\Filament\Resources\FileResource\Pages\ListFiles;
use App\Filament\Resources\FileResource\Pages\ViewFile;
use App\Models\File;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static string|\BackedEnum|null $navigationIcon = "heroicon-o-photo";

    protected static ?string $navigationLabel = 'Media Library';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('file')
                    ->label('Upload File')
                    ->required()
                    ->disk('public')
                    ->directory('files')
                    ->preserveFilenames()
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/*', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->helperText('Max size: 10MB. Allowed: Images, PDF, DOC, DOCX')
                    ->columnSpanFull(),
                
                Select::make('collection')
                    ->label('Collection')
                    ->options([
                        'products' => 'Products',
                        'posts' => 'Posts',
                        'avatars' => 'Avatars',
                        'general' => 'General',
                    ])
                    ->required(),
                
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->label('Preview')
                    ->width(50)
                    ->imageHeight(50)
                    ->rounded(),
                
                TextColumn::make('name')
                    ->label('File Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(30),
                
                TextColumn::make('collection')
                    ->label('Collection')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'products' => 'success',
                        'posts' => 'info',
                        'avatars' => 'warning',
                        default => 'gray',
                    }),
                
                TextColumn::make('size_formatted')
                    ->label('Size')
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
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
    return $schema
        ->components([
            Section::make('File Details')
                ->schema([
                    ImageEntry::make('path')
                        ->label('Preview')
                        ->visible(fn(File $record) => $record->isImage())
                        ->height(400)
                        ->width(600),
                    
                    TextEntry::make('name')->label('File Name'),
                    TextEntry::make('collection')->label('Collection')->badge(),
                    TextEntry::make('mime_type')->label('MIME Type'),
                    TextEntry::make('size_formatted')->label('Size'),
                    TextEntry::make('description')->label('Description'),
                    TextEntry::make('user.name')->label('Uploaded By'),
                    TextEntry::make('created_at')->label('Uploaded At')->dateTime('F j, Y g:i A'),
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
            'index' => ListFiles::route('/'),
            'create' => CreateFile::route('/create'),
            'view' => ViewFile::route('/{record}'),
            'edit' => EditFile::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}