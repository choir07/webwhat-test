<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserProfile extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected string $view = 'filament.pages.user-profile';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill(auth()->user()->only(['name', 'email']));
    }
    
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('avatar')
                    ->label('Profile Picture')
                    ->image()
                    ->imageEditor()
                    ->circleCropper()
                    ->directory('avatars')
                    ->maxSize(2048),
                
                TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('email')
                    ->label('Email Address')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                
                TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->required()
                    ->rule('current_password'),
                
                TextInput::make('new_password')
                    ->label('New Password')
                    ->password()
                    ->minLength(8)
                    ->same('password_confirmation'),
                
                TextInput::make('password_confirmation')
                    ->label('Confirm New Password')
                    ->password(),
            ])
            ->statePath('data');
    }
    
    public function updateProfile(): void
    {
        $data = $this->form->getState();
        
        $user = auth()->user();
        $user->name = $data['name'];
        $user->email = $data['email'];
        
        if (!empty($data['avatar'])) {
            $user->avatar = $data['avatar'];
        }
        
        if (!empty($data['new_password'])) {
            $user->password = Hash::make($data['new_password']);
        }
        
        $user->save();
        
        Notification::make()
            ->title('Profile updated successfully!')
            ->success()
            ->send();
            
        $this->redirect(route('filament.admin.pages.dashboard'));
    }
}