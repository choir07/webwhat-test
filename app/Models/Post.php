<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'description',  
        'author_id',
        'featured_image_id',  
        'featured_image',      
        'gallery',
        'cloudinary_public_id',
        'status',
        'published_at',
        'is_featured',
        'priority',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'status' => \App\Enums\Status::class,
        'priority' => \App\Enums\Priority::class,
        'views' => 'integer',
        'gallery' => 'array',
    ];

    protected $appends = ['reading_time', 'featured_image_url', 'gallery_images'];

    // Relationship to File model for featured image
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(\App\Models\File::class, 'featured_image_id');
    }

    // Accessor to get featured image URL
    public function getFeaturedImageUrlAttribute(): ?string
    {
        // First check if there's a direct file path
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }

        // Then check if there's a file relationship
        if ($this->featured_image_id && $this->featuredImageFile) {
            return $this->featuredImage->url;
        }

        return null;
    }

    // Accessor to get all gallery images with URLs
    public function getGalleryImagesAttribute(): array
    {
        $images = [];

        // If gallery is stored as JSON with file IDs or paths
        if ($this->gallery && is_array($this->gallery)) {
            foreach ($this->gallery as $item) {
                if (isset($item['file_id'])) {
                    $file = File::find($item['file_id']);
                    if ($file) {
                        $images[] = [
                            'url' => $file->url,
                            'caption' => $item['caption'] ?? null,
                            'sort_order' => $item['sort_order'] ?? 0,
                        ];
                    }
                } elseif (isset($item['image'])) {
                    $images[] = [
                        'url' => asset('storage/' . $item['image']),
                        'caption' => $item['caption'] ?? null,
                        'sort_order' => $item['sort_order'] ?? 0,
                    ];
                }
            }
        }

        return $images;
    }

     public function getImageUrlAttribute(): string
    {
        if ($this->cloudinary_public_id) {
            return 'https://res.cloudinary.com/dgk1pwiet/image/upload/' . $this->cloudinary_public_id;
        }
        return $this->featured_image ?? 'https://picsum.photos/seed/' . $this->id . '/800/400';
    }

    // Helper to get transformed image URL
    public function getOptimizedImageUrlAttribute(): string
    {
        if ($this->cloudinary_public_id) {
            return 'https://res.cloudinary.com/dgk1pwiet/image/upload/f_auto,q_auto/' . $this->cloudinary_public_id;
        }
        return $this->featured_image ?? 'https://picsum.photos/seed/' . $this->id . '/800/400';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getReadingTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->content ?? $this->description ?? ''));
        $minutes = ceil($words / 200);
        return $minutes . ' min read';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
    public function postImages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\PostImage::class)->orderBy('sort_order');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}