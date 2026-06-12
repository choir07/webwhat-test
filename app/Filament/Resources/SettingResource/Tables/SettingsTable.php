<?php

namespace App\Filament\Resources\SettingResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Setting Key')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Key copied')
                    ->weight('bold'),
                
                TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->searchable(),
                
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn($state): string => match($state) {
                        'string' => 'gray',
                        'integer' => 'info',
                        'boolean' => 'warning',
                        'array' => 'success',
                        'text' => 'primary',
                        default => 'gray',
                    }),
                
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
                    ->label('Last Updated')
                    ->dateTime('M d, Y')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('group', 'asc')
            ->searchPlaceholder('Search settings...')
            ->filters([
                // Add filters for group and type
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}