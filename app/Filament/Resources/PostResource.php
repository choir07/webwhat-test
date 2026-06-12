<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\Tag;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Blog Posts';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Main Content Section
                \Filament\Schemas\Components\Section::make('Post Content')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Post::class, 'slug', ignoreRecord: true)
                            ->helperText('URL-friendly version of the title'),

                        Textarea::make('excerpt')
                            ->label('Excerpt / Summary')
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('A short summary of the post (max 500 characters)'),

                        RichEditor::make('content')
                            ->label('Content')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h1',
                                'h2',
                                'h3',
                                'h4',
                                'h5',
                                'h6',
                                'blockquote',
                                'codeBlock',
                                'table',
                                'undo',
                                'redo',
                            ])
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('post-images'),
                    ])->columns(1),

                // Post Settings Section
                \Filament\Schemas\Components\Section::make('Post Settings')
                    ->schema([
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TagsInput::make('tags')
                            ->label('Tags')
                            ->placeholder('Add tags...')
                            ->separator(',')
                            ->suggestions(function () {
                                return Tag::pluck('name')->toArray();
                            })
                            ->helperText('Press Enter to add a tag'),

                        Select::make('author_id')
                            ->label('Author')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(auth()->id()),

                        FileUpload::make('featured_image_id')
                            ->label('Featured Image')
                            ->relationship('featuredImage', 'id')
                            ->disk('public')
                            ->directory('posts')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('630')
                            ->helperText('Recommended size: 1200x630px'),

                        DateTimePicker::make('published_at')
                            ->label('Publish Date & Time')
                            ->default(now())
                            ->helperText('When should this post be published?'),

                        Select::make('status')
                            ->options(\App\Enums\Status::class)
                            ->required(),

                        Toggle::make('is_featured')
                            ->label('Feature this post')
                            ->helperText('Featured posts appear on the homepage'),

                        Toggle::make('allow_comments')
                            ->label('Allow comments')
                            ->default(true),
                    ])->columns(2),

                // SEO Section
                \Filament\Schemas\Components\Section::make('SEO Settings')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Recommended length: 50-60 characters'),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(2)
                            ->helperText('Recommended length: 150-160 characters'),

                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('keyword1, keyword2, keyword3')
                            ->helperText('Comma-separated keywords'),
                    ])->columns(1)->collapsible(),

                \Filament\Schemas\Components\Section::make('Image Gallery')
                    ->description('Add multiple images to your post. Perfect for photo galleries or step-by-step visuals.')
                    ->schema([
                        Repeater::make('postImages')
                            ->relationship('postImages')
                            ->schema([
                                Select::make('file_id')
                                    ->label('Image')
                                    ->options(\App\Models\File::pluck('name', 'id')->toArray())
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->helperText('Select an image from Media Library'),

                                TextInput::make('caption')
                                    ->label('Caption')
                                    ->maxLength(255)
                                    ->helperText('Optional description for this image'),

                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first'),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->collapsible()
                            ->cloneable()
                            ->reorderableWithDragAndDrop()
                            ->itemLabel(fn(array $state): ?string => $state['caption'] ?: 'Post Image')
                            ->collapsible(),
                    ])

            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featuredImage.url')
                    ->label('Image')
                    ->width(60)
                    ->imageHeight(60)
                    ->circular()
                    ->defaultImageUrl('/images/placeholder.png'),

                TextColumn::make('post_images_count')
                    ->label('Images')
                    ->counts('postImages')
                    ->badge()
                    ->color('success')
                    ->toggleable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable(),

                IconColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'danger',
                        default => 'gray',
                    }),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->sortable(),

                TextColumn::make('views')
                    ->label('Views')
                    ->sortable()
                    ->numeric(),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('M d, Y')
                    ->sortable(),

                TextColumn::make('reading_time')
                    ->label('Read Time')
                    ->badge(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
                SelectFilter::make('author')
                    ->relationship('author', 'name'),
                SelectFilter::make('is_featured')
                    ->label('Featured')
                    ->options([
                        '1' => 'Featured',
                        '0' => 'Not Featured',
                    ]),
            ])
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
                \Filament\Schemas\Components\Section::make('Post Details')
                    ->schema([
                        \Filament\Schemas\Components\Group::make()
                            ->schema([
                                ImageEntry::make('featuredImage.url')
                                    ->label('Featured Image')
                                    ->imageHeight(300)
                                    ->imageWidth('100%')
                                    ->defaultImageUrl('/images/placeholder.png'),
                            ])
                            ->columnSpanFull(),

                        \Filament\Schemas\Components\Grid::make(2)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Title')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold'),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'published' => 'success',
                                        'draft' => 'gray',
                                        'archived' => 'danger',
                                    }),

                                TextEntry::make('category.name')
                                    ->label('Category')
                                    ->badge(),

                                TextEntry::make('author.name')
                                    ->label('Author'),

                                TextEntry::make('published_at')
                                    ->label('Published Date')
                                    ->dateTime('F j, Y g:i A'),

                                TextEntry::make('reading_time')
                                    ->label('Reading Time')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('views')
                                    ->label('Views')
                                    ->numeric(),

                                TextEntry::make('is_featured')
                                    ->label('Featured')
                                    ->badge()
                                    ->formatStateUsing(fn(bool $state): string => $state ? 'Yes' : 'No')
                                    ->color(fn(bool $state): string => $state ? 'warning' : 'gray'),
                            ]),

                        TextEntry::make('excerpt')
                            ->label('Excerpt')
                            ->columnSpanFull(),

                        TextEntry::make('content')
                            ->label('Content')
                            ->html()
                            ->columnSpanFull(),

                        TextEntry::make('tags.name')
                            ->label('Tags')
                            ->badge()
                            ->separator(',')
                            ->columnSpanFull(),
                    ]),

                InfolistSection::make('SEO Information')
                    ->schema([
                        TextEntry::make('meta_title')
                            ->label('Meta Title'),
                        TextEntry::make('meta_description')
                            ->label('Meta Description'),
                        TextEntry::make('meta_keywords')
                            ->label('Meta Keywords'),
                    ])
                    ->collapsible(),

                InfolistSection::make('Image Gallery')
                    ->schema([
                        RepeatableEntry::make('postImages')
                            ->label('')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        ImageEntry::make('file.url')
                                            ->label('')
                                            ->imageHeight(150)
                                            ->imageWidth(150)
                                            ->circular(),

                                        TextEntry::make('caption')
                                            ->label('Caption')
                                            ->placeholder('No caption'),
                                    ]),
                            ])
                            ->columnSpanFull()
                            ->grid(2),
                    ])
                    ->collapsible(),

            ]);

    }
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'draft')->count() ?: null;
    }
}