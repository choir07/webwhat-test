# update-user-model-activity.ps1
Write-Host "Adding activity logging to User model..." -ForegroundColor Cyan

$userPath = "C:\Users\User\f5_crud\app\Models\User.php"
$userContent = @'
<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Created user: ' . $this->name,
                'updated' => 'Updated user: ' . $this->name,
                'deleted' => 'Deleted user: ' . $this->name,
                default => $eventName,
            });
    }
    
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?background=f59e0b&color=fff&name=' . urlencode($this->name);
    }
}
'@

[System.IO.File]::WriteAllText($userPath, $userContent, [System.Text.UTF8Encoding]::new($false))
Write-Host "Updated User model with activity logging" -ForegroundColor Green