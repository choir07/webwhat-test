<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        "name",
        "email",
        "password",
        "avatar",
    ];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }
    
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset("storage/" . $this->avatar)
            : "https://ui-avatars.com/api/?background=f59e0b&color=fff&name=" . urlencode($this->name);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Option 1 - allow all authenticated users:
        return true;

        // Option 2 - only users with admin role (if using Spatie):
        // return $this->hasRole('admin');

        // Option 3 - only specific email:
        // return $this->email === 'ntah12345@gmail.com';
    }
}