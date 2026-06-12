# update-product-model.ps1
Write-Host "Adding activity logging to Product model..." -ForegroundColor Cyan

$productPath = "C:\Users\User\f5_crud\app\Models\Product.php"
$productContent = @'
<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'sku',
        'status',
        'category_id'
    ];

    protected $casts = [
        'status' => ProductStatus::class,
        'price' => 'decimal:2',
        'stock' => 'integer'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'price', 'stock', 'status', 'sku'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Created product: ' . $this->name,
                'updated' => 'Updated product: ' . $this->name,
                'deleted' => 'Deleted product: ' . $this->name,
                default => $eventName,
            });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }
}
'@

[System.IO.File]::WriteAllText($productPath, $productContent, [System.Text.UTF8Encoding]::new($false))
Write-Host "Updated Product model with activity logging" -ForegroundColor Green