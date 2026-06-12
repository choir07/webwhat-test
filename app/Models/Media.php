<?php

namespace App\Models;

use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;
use Spatie\MediaLibrary\Conversions\ConversionCollection;

class Media extends BaseMedia
{
    protected $appends = ['url', 'thumb_url', 'large_url'];
    
    public function getUrlAttribute(): string
    {
        return $this->getUrl();
    }
    
    public function getThumbUrlAttribute(): string
    {
        return $this->getUrl('thumb');
    }
    
    public function getLargeUrlAttribute(): string
    {
        return $this->getUrl('large');
    }
}