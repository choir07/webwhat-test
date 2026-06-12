<?php

namespace App\Filament\Resources\SettingResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('app.name')
                    ->helperText('Unique identifier for this setting (use dot notation for grouping: general.site_name)'),
                
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
                    ->helperText('Depending on the type selected, enter appropriate value (JSON for array, true/false for boolean)')
                    ->columnSpanFull(),
                
                Toggle::make('is_public')
                    ->label('Public Access')
                    ->helperText('If enabled, this setting can be accessed by frontend users'),
            ]);
    }
}