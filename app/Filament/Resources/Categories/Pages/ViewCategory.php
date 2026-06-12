<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
        Action::make('back')
        ->label('Back')    
        ->icon('heroicon-o-arrow-left')    
        ->color('gray')    
        ->url(CategoryResource::getUrl('index')),    
        EditAction::make(),
        ];
    }
}
