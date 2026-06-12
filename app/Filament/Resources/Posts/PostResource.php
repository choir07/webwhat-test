<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages\CreatePost; 
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPost;
use App\Filament\Resources\Posts\Pages\ViewPost;
use App\Filament\Resources\Posts\Schemas\PostForm;
use App\Filament\Resources\Posts\Schemas\PostInfolist;
use App\Filament\Resources\Posts\Tables\PostsTable;
use App\Models\Post;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PostForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PostInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
    return $table
        ->columns([
            ImageColumn::make('featuredImage.url')
                ->label('Image')
                ->width(50)
                ->imageHeight(50)
                ->circular()
                ->defaultImageUrl('https://via.placeholder.com/50x50?text=No+Image'),
            
            TextColumn::make('id')
                ->label('ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            
            TextColumn::make('title')
                ->label('Title')
                ->searchable()
                ->sortable()
                ->limit(50)
                ->weight('bold')
                ->copyable(),
            
            TextColumn::make('slug')
                ->label('Slug')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            
            TextColumn::make('category.name')
                ->label('Category')
                ->sortable()
                ->badge()
                ->color('primary')
                ->toggleable(),
            
            TextColumn::make('author.name')
                ->label('Author')
                ->sortable()
                ->searchable()
                ->toggleable(),
            
            IconColumn::make('status')
                ->label('Published')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-clock')
                ->trueColor('success')
                ->falseColor('warning')
                ->sortable(),
            
            IconColumn::make('is_featured')
                ->label('Featured')
                ->boolean()
                ->trueIcon('heroicon-o-star')
                ->falseIcon('heroicon-o-star')
                ->trueColor('warning')
                ->falseColor('gray')
                ->sortable(),
            
            TextColumn::make('views')
                ->label('Views')
                ->sortable()
                ->numeric()
                ->toggleable(),
            
            TextColumn::make('published_at')
                ->label('Published Date')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(),
            
            TextColumn::make('created_at')
                ->label('Created')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            
            TextColumn::make('updated_at')
                ->label('Updated')
                ->dateTime('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->defaultSort('published_at', 'desc')
        ->defaultSort(function ($query) {
            $query->orderByRaw('COALESCE(published_at, created_at) DESC');
        })
        ->searchable()
        ->filters([
            SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ]),
            
            SelectFilter::make('category')
                ->label('Category')
                ->relationship('category', 'name'),
            
            SelectFilter::make('author')
                ->label('Author')
                ->relationship('author', 'name'),
            
            SelectFilter::make('is_featured')
                ->label('Featured')
                ->options([
                    '1' => 'Featured',
                    '0' => 'Not Featured',
                ]),
            
            \Filament\Tables\Filters\Filter::make('published')
                ->label('Published Posts')
                ->query(fn ($query) => $query->where('status', 'published')),
            
            \Filament\Tables\Filters\Filter::make('draft')
                ->label('Draft Posts')
                ->query(fn ($query) => $query->where('status', 'draft')),
        ])
        ->actions([
            \Filament\Actions\ViewAction::make()
                ->label('')
                ->tooltip('View'),
            \Filament\Actions\EditAction::make()
                ->label('')
                ->tooltip('Edit'),
            \Filament\Actions\DeleteAction::make()
                ->label('')
                ->tooltip('Delete'),
        ])
        ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
                BulkAction::make('publish')
                    ->label('Publish Selected')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn ($records) => $records->each->update(['status' => 'published', 'published_at' => now()]))
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('draft')
                    ->label('Move to Draft')
                    ->icon('heroicon-o-clock')
                    ->color('warning')
                    ->action(fn ($records) => $records->each->update(['status' => 'draft']))
                    ->deselectRecordsAfterCompletion(),
            ]),
        ])
        ->emptyStateHeading('No posts yet')
        ->emptyStateDescription('Create your first blog post to get started.')
        ->emptyStateIcon('heroicon-o-document-text')
        ->emptyStateActions([
            \Filament\Actions\Action::make('create')
                ->label('Create Post')
                ->url(route('filament.admin.resources.posts.create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ]); 
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPost::route('/'),
            'create' => CreatePost::route('/create'),
            'view' => ViewPost::route('/{record}'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }
}
