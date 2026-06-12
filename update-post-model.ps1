# update-post-model.ps1
Write-Host "Adding activity logging to Post model..." -ForegroundColor Cyan

$postPath = "C:\Users\User\f5_crud\app\Models\Post.php"
$postContent = @'
<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Post extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title', 
        'description', 
        'status', 
        'priority', 
        'category_id'
    ];

    protected $casts = [
        'status' => Status::class,
        'priority' => Priority::class
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'priority'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Created post: ' . $this->title,
                'updated' => 'Updated post: ' . $this->title,
                'deleted' => 'Deleted post: ' . $this->title,
                default => $eventName,
            });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
'@

if (Test-Path $postPath) {
    [System.IO.File]::WriteAllText($postPath, $postContent, [System.Text.UTF8Encoding]::new($false))
    Write-Host "Updated Post model with activity logging" -ForegroundColor Green
} else {
    Write-Host "Post model not found, skipping" -ForegroundColor Yellow
}