# update-category-model.ps1
Write-Host "Adding activity logging to Category model..." -ForegroundColor Cyan

$categoryPath = "C:\Users\User\f5_crud\app\Models\Category.php"
$categoryContent = @'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{
    use LogsActivity;

    protected $fillable = ["name", "description"];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Created category: ' . $this->name,
                'updated' => 'Updated category: ' . $this->name,
                'deleted' => 'Deleted category: ' . $this->name,
                default => $eventName,
            });
    }
    
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
'@

if (Test-Path $categoryPath) {
    [System.IO.File]::WriteAllText($categoryPath, $categoryContent, [System.Text.UTF8Encoding]::new($false))
    Write-Host "Updated Category model with activity logging" -ForegroundColor Green
} else {
    Write-Host "Category model not found, skipping" -ForegroundColor Yellow
}