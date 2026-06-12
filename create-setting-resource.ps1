# create-setting-resource.ps1
Write-Host "Creating Setting Resource..." -ForegroundColor Cyan

$basePath = "C:\Users\User\f5_crud"

# Create SettingResource.php
$resourceContent = @'
<?php

namespace App\Filament\Resources;

use App\Models\Setting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Settings';
    
    protected static ?int $navigationSort = 999;
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Setting Details')
                    ->schema([
                        TextEntry::make('key')->label('Key'),
                        TextEntry::make('type')->label('Type')->badge(),
                        TextEntry::make('group')->label('Group')->badge(),
                        TextEntry::make('value')->label('Value')->columnSpanFull(),
                        TextEntry::make('is_public')->label('Public Access')->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No'),
                        TextEntry::make('created_at')->label('Created')->dateTime(),
                        TextEntry::make('updated_at')->label('Updated')->dateTime()->since(),
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
            'index' => \App\Filament\Resources\SettingResource\Pages\ListSettings::route('/'),
            'create' => \App\Filament\Resources\SettingResource\Pages\CreateSetting::route('/create'),
            'view' => \App\Filament\Resources\SettingResource\Pages\ViewSetting::route('/{record}'),
            'edit' => \App\Filament\Resources\SettingResource\Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
'@

$resourcePath = "$basePath/app/Filament/Resources/SettingResource.php"
[System.IO.File]::WriteAllText($resourcePath, $resourceContent, [System.Text.UTF8Encoding]::new($false))
Write-Host "Created SettingResource.php" -ForegroundColor Green

Write-Host "Done! Now run: php artisan optimize:clear" -ForegroundColor Yellow