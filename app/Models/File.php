<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    protected $table = "files";

    protected $fillable = [
        "name",
        "original_name",
        "path",
        "type",
        "mime_type",
        "size",
        "collection",
        "description",
        "user_id",
    ];

    protected $appends = ["url", "size_formatted"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        $filename = basename($this->path);
        $encodedFilename = rawurlencode($filename);
        return asset('storage/files/' . $encodedFilename);
    }

    public function getSizeFormattedAttribute(): string
    {
        $bytes = $this->size;
        $units = ["B", "KB", "MB", "GB"];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . " " . $units[$i];
    }

    public function isImage(): bool
    {
        return str_starts_with($this->mime_type, "image/");
    }
}