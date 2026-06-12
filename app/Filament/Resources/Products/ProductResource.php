<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages;
use App\Models\Product;
use App\Models\ProductImage;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Columns\ImageColumn;
use Filament\Columns\TextColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Products';

    protected static string|\UnitEnum|null $navigationGroup = 'Shop';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                            
                        Textarea::make('description')
                            ->required()
                            ->rows(3),
                        
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        
                        TextInput::make('stock')
                            ->required()
                            ->numeric()
                            ->default(0),
                        
                        TextInput::make('sku')
                            ->required()
                            ->unique(ignoreRecord: true),
                        
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('published'),
                        
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),
                    ])->columns(2),
                
                // Multiple Images Section
                \Filament\Schemas\Components\Section::make('Product Gallery')
                    ->description('Add multiple images to showcase your product. Set one as primary (main image).')
                    ->schema([
                        Repeater::make('product_images')
                            ->relationship('productImages')
                            ->schema([
                                Select::make('file_id')
                                    ->label('Image')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->options(function () {
                                        return \App\Models\File::pluck('name', 'id')->toArray();
                                    }),
                                
                                TextInput::make('alt_text')
                                    ->label('Alt Text')
                                    ->maxLength(255),
                                
                                Toggle::make('is_primary')
                                    ->label('Primary Image')
                                    ->default(false)
                                    ->afterStateUpdated(function ($state, $get, $set, $livewire) {
                                        // Ensure only one primary image per product
                                        if ($state) {
                                            $items = $livewire->data['product_images'] ?? [];
                                            foreach ($items as $index => $item) {
                                                if (isset($item['id']) && $item['id'] !== ($livewire->record?->id)) {
                                                    $set("product_images.{$index}.is_primary", false);
                                                }
                                            }
                                        }
                                    }),
                                
                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0),
                                    
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->collapsible()
                            ->cloneable()
                            ->reorderableWithDragAndDrop()
                            ->itemLabel(fn(array $state): ?string => $state['alt_text'] ?: 'Product Image'),
                    ])->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                
                \Filament\Tables\Columns\ImageColumn::make('productImages.file.url')
                    ->label('image')
                    ->width(60)
                    ->imageHeight(60)
                    ->circular()
                    ->getStateUsing(function ($record) {
                        // Get the primary image or first image
                        $primary = $record->productImages->where('is_primary', true)->first();
                        if ($primary) {
                            return $primary->file?->url;
                        }
                        $first = $record->productImages->first();
                        return $first?->file?->url;
                    })
                    ->defaultImageUrl('https://via.placeholder.com/60x60?text=No+Image'),
                
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),
                
                \Filament\Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                
                \Filament\Tables\Columns\TextColumn::make('stock')
                    ->sortable(),
                
                \Filament\Tables\Columns\TextColumn::make('product_images_count')
                    ->label('Images')
                    ->counts('productImages')
                    ->badge()
                    ->color(fn($record): string => match ($record->status->value) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
                
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($record): string => match ($record->status->value) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'danger',
                        default => 'gray',
                    }),
                
                \Filament\Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->searchable()
            ->filters([])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
            
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Product Information')
                    ->schema([
                        ImageEntry::make('productImages')
                            ->label('Primary Image')
                            ->imageHeight(200)
                            ->imageWidth(200)
                            ->circular()
                            ->getStateUsing(function ($record) {
                                $primary = $record->productImages->where('is_primary', true)->first();
                                if ($primary) {
                                    return $primary->file?->url;
                                }
                                $first = $record->productImages->first();
                                return $first?->file?->url;
                            })
                            ->defaultImageUrl('https://via.placeholder.com/200x200?text=No+Primary+Image'),
                        
                        TextEntry::make('name')
                            ->label('Product Name'),
                        
                        TextEntry::make('description')
                            ->label('Description')
                            ->html(),
                        
                        TextEntry::make('price')
                            ->label('Price')
                            ->money('USD'),
                        
                        TextEntry::make('stock')
                            ->label('Stock Quantity'),
                        
                        TextEntry::make('sku')
                            ->label('SKU'),
                        
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn($record): string => ucfirst($record->status->value))
                            ->color(fn($record): string => match ($record->status->value) {
                                'draft' => 'gray',
                                'published' => 'success',
                                'archived' => 'danger',
                                default => 'gray',
                            }),
                        
                        TextEntry::make('category.name')
                            ->label('Category'),
                        
                        TextEntry::make('created_at')
                            ->label('Created Date')
                            ->dateTime('F j, Y g:i A'),
                        
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('F j, Y g:i A'),
                    ])
                    ->columns(2),
                
                \Filament\Schemas\Components\Section::make('Product Gallery')
                    ->schema([
                        RepeatableEntry::make('productImages')
                            ->label('')
                            ->schema([
                                \Filament\Schemas\Components\Grid::make(4)
                                    ->schema([
                                        ImageEntry::make('file.url')
                                            ->label('')
                                            ->imageHeight(150)
                                            ->imageWidth(150)
                                            ->circular(),
                                        
                                        TextEntry::make('is_primary')
                                            ->label('')
                                            ->badge()
                                            ->formatStateUsing(fn($state) => $state ? '✓ Primary' : '')
                                            ->color('success')
                                            ->visible(fn($state) => $state),
                                        
                                        TextEntry::make('alt_text')
                                            ->label('Alt Text')
                                            ->placeholder('No alt text'),
                                    ]),
                            ])
                            ->columnSpanFull()
                            ->grid(2),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function exportProducts(Collection $products)
    {
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "products_export_{$timestamp}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        
        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            
            fputcsv($file, [
                'ID', 'Product Name', 'Description', 'Price (USD)', 
                'Stock', 'SKU', 'Status', 'Category', 'Primary Image URL', 
                'Number of Images', 'Created Date', 'Updated Date'
            ]);
            
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    strip_tags($product->description),
                    $product->price,
                    $product->stock,
                    $product->sku,
                    $product->status->value ?? $product->status,
                    $product->category?->name ?? 'N/A',
                    $product->image_url,
                    $product->productImages->count(),
                    $product->created_at?->format('Y-m-d H:i:s'),
                    $product->updated_at?->format('Y-m-d H:i:s'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->streamDownload($callback, $filename, $headers);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}