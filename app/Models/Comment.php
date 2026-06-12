<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'post_id',
        'author_name',
        'author_email',
        'content',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    
    public function getAvatarAttribute(): string
    {
        $hash = md5(strtolower(trim($this->author_email)));
        return "https://www.gravatar.com/avatar/$hash?s=50&d=mp";
    }
}
