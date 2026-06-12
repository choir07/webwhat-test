<?php

namespace App\Filament\Resources\Comments;

use App\Filament\Resources\Comments\Pages\CreateComment;
use App\Filament\Resources\Comments\Pages\EditComment;
use App\Filament\Resources\Comments\Pages\ListComments;
use App\Filament\Resources\Comments\Pages\ViewComment;
use App\Filament\Resources\Comments\Schemas\CommentInfolist;
use App\Models\Comment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Table;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    // ❌ Was: missing closing quote on string
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $navigationLabel = 'Comments';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('post_id')
                    ->relationship('post', 'title')
                    ->required(),

                TextInput::make('author_name')
                    ->required(),

                TextInput::make('author_email')
                    ->email()
                    ->required(),

                Textarea::make('content')
                    ->required()
                    ->rows(4),

                Toggle::make('is_approved')
                    ->label('Approved')
                    ->default(false),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CommentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('post.title')
                    ->label('Post')
                    ->searchable(),

                TextColumn::make('author_name')
                    ->searchable(),

                TextColumn::make('content')
                    ->limit(50),

                IconColumn::make('is_approved')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('is_approved')
                    ->options([
                        '1' => 'Approved',
                        '0' => 'Pending',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('approve')
                    ->action(fn(Comment $record) => $record->update(['is_approved' => true]))
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListComments::route('/'),
            'create' => CreateComment::route('/create'),
            'view'   => ViewComment::route('/{record}'),
            'edit'   => EditComment::route('/{record}/edit'),
        ];
    }
}