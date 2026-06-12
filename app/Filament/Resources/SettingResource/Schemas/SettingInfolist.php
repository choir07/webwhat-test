<?php

namespace App\Filament\Resources\SettingResource\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SettingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Setting Details')
                    ->schema([
                        TextEntry::make('key')
                            ->label('Key')
                            ->copyable()
                            ->copyMessage('Key copied'),
                        
                        TextEntry::make('type')
                            ->label('Type')
                            ->badge()
                            ->color('info'),
                        
                        TextEntry::make('group')
                            ->label('Group')
                            ->badge()
                            ->color('primary'),
                        
                        TextEntry::make('value')
                            ->label('Value')
                            ->columnSpanFull()
                            ->markdown(),
                        
                        TextEntry::make('is_public')
                            ->label('Public Access')
                            ->badge()
                            ->formatStateUsing(fn($state) => $state ? 'Yes' : 'No')
                            ->color(fn($state) => $state ? 'success' : 'gray'),
                        
                        TextEntry::make('created_at')
                            ->label('Created')
                            ->dateTime(),
                        
                        TextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime()
                            ->since(),
                    ])
                    ->columns(2),
            ]);
    }
}