<?php

namespace App\Models;

use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "price",
        "stock",
        "sku",
        "status",
        "category_id",
        "image_id",  // Keep for backward compatibility
    ];

    protected $casts = [
        "status" => ProductStatus::class,
        "price" => "decimal:2",
        "stock" => "integer"
    ];

    protected $appends = ['primary_image_url', 'all_images'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Keep old single image relationship for backward compatibility
    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    // New multiple images relationship
    public function productImages()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    // Get primary image from the gallery
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    // Accessor for primary image URL
    public function getPrimaryImageUrlAttribute(): ?string
    {
        $primary = $this->primaryImage()->first();
        if ($primary && $primary->file) {
            return $primary->file->url;
        }
        
        // Fallback to first image if no primary set
        $firstImage = $this->productImages()->first();
        if ($firstImage && $firstImage->file) {
            return $firstImage->file->url;
        }
        
        // Fallback to old single image
        return $this->image?->url;
    }

    // Get all images as array
    public function getAllImagesAttribute()
    {
        $images = [];
        foreach ($this->productImages as $productImage) {
            if ($productImage->file) {
                $images[] = [
                    'id' => $productImage->id,
                    'url' => $productImage->file->url,
                    'is_primary' => $productImage->is_primary,
                    'alt_text' => $productImage->alt_text,
                    'sort_order' => $productImage->sort_order,
                ];
            }
        }
        
        // If no gallery images, check old single image
        if (empty($images) && $this->image) {
            $images[] = [
                'id' => null,
                'url' => $this->image->url,
                'is_primary' => true,
                'alt_text' => null,
                'sort_order' => 0,
            ];
        }
        
        return $images;
    }

    public function getFormattedPriceAttribute(): string
    {
        return "$" . number_format($this->price, 2);
    }
}