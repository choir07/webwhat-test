<?php

namespace App\Filament\Resources;

use App\Models\Setting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Settings';
    
    protected static ?int $navigationSort = 999;
    
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('general.site_name')
                    ->helperText('Unique identifier (use dot notation: group.key)'),
                
                Select::make('type')
                    ->options([
                        'string' => 'String',
                        'integer' => 'Integer',
                        'boolean' => 'Boolean',
                        'array' => 'Array/JSON',
                        'text' => 'Text',
                    ])
                    ->required()
                    ->default('string'),
                
                Select::make('group')
                    ->options([
                        'general' => 'General',
                        'appearance' => 'Appearance',
                        'email' => 'Email',
                        'security' => 'Security',
                        'integrations' => 'Integrations',
                    ])
                    ->required()
                    ->default('general'),
                
                Textarea::make('value')
                    ->label('Value')
                    ->rows(5)
                    ->helperText('Enter the setting value')
                    ->columnSpanFull(),
                
                Toggle::make('is_public')
                    ->label('Public Access')
                    ->helperText('If enabled, this setting can be accessed by frontend users')
                    ->default(false),
            ]);
    }
    
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Setting Details')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('key')->label('Key'),
                        \Filament\Infolists\Components\TextEntry::make('type')->label('Type')->badge(),
                        \Filament\Infolists\Components\TextEntry::make('group')->label('Group')->badge(),
                        \Filament\Infolists\Components\TextEntry::make('value')->label('Value')->columnSpanFull(),
                        \Filament\Infolists\Components\TextEntry::make('is_public')->label('Public Access')->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
                        \Filament\Infolists\Components\TextEntry::make('created_at')->label('Created')->dateTime(),
                        \Filament\Infolists\Components\TextEntry::make('updated_at')->label('Updated')->dateTime()->since(),
                    ])
                    ->columns(2),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Setting Key')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),
                
                TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->searchable(),
                
                TextColumn::make('type')
                    ->label('Type')
                    ->badge(),
                
                TextColumn::make('group')
                    ->label('Group')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                
                IconColumn::make('is_public')
                    ->label('Public')
                    ->boolean()
                    ->sortable(),
                
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M d, Y')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('group', 'asc')
            ->searchPlaceholder('Search settings...')
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
    
    public static function getRelations(): array
    {
        return [];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\SettingResource\Pages\ListSettings::route('/'),
            'create' => \App\Filament\Resources\SettingResource\Pages\CreateSetting::route('/create'),
            'view' => \App\Filament\Resources\SettingResource\Pages\ViewSetting::route('/{record}'),
            'edit' => \App\Filament\Resources\SettingResource\Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}