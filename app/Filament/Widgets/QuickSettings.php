<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class QuickSettings extends Widget
{
    protected static string $view = 'filament.widgets.quick-settings';
    
    protected int | string | array $columnSpan = 'full';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->data = [
            'site_name' => Setting::get('general.site_name', 'My App'),
            'theme' => Setting::get('appearance.theme', 'light'),
            'sidebar_collapsed' => Setting::get('appearance.sidebar_collapsed', false),
        ];
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('theme')
                    ->label('Theme')
                    ->options([
                        'light' => 'Light',
                        'dark' => 'Dark',
                        'system' => 'System',
                    ])
                    ->default('light'),
                
                Toggle::make('sidebar_collapsed')
                    ->label('Collapse Sidebar')
                    ->default(false),
            ])
            ->statePath('data');
    }
    
    public function save(): void
    {
        Setting::set('appearance.theme', $this->data['theme'], 'appearance');
        Setting::set('appearance.sidebar_collapsed', $this->data['sidebar_collapsed'], 'appearance');
        
        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
    
    protected function getFormSchema(): array
    {
        return [
            Select::make('theme')
                ->label('Theme')
                ->options([
                    'light' => 'Light',
                    'dark' => 'Dark',
                    'system' => 'System',
                ]),
            Toggle::make('sidebar_collapsed')
                ->label('Collapse Sidebar'),
        ];
    }
}