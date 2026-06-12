<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewActivityLog extends ViewRecord
{
    protected static string $resource = ActivityLogResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Activity Details')
                    ->schema([
                        TextEntry::make('log_name')
                            ->label('Type')
                            ->badge(),
                        
                        TextEntry::make('description')
                            ->label('Action')
                            ->columnSpanFull(),
                        
                        TextEntry::make('subject_type')
                            ->label('Subject Type')
                            ->formatStateUsing(fn($state) => class_basename($state)),
                        
                        TextEntry::make('subject_id')
                            ->label('Subject ID'),
                        
                        TextEntry::make('causer.name')
                            ->label('User'),
                        
                        TextEntry::make('causer.email')
                            ->label('User Email'),
                        
                        TextEntry::make('properties')
                            ->label('Properties')
                            ->formatStateUsing(fn($state) => json_encode($state, JSON_PRETTY_PRINT))
                            ->columnSpanFull()
                            ->markdown(),
                        
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime('M d, Y H:i:s'),
                        
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime('M d, Y H:i:s'),
                    ])
                    ->columns(2),
            ]);
    }
}