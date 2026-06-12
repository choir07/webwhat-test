<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'is_public',
    ];
    
    protected $casts = [
        'is_public' => 'boolean',
    ];
    
    // Helper method to get setting value
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        return match($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $setting->value,
            'array', 'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }
    
    // Helper method to set setting value
    public static function set(string $key, $value, string $group = 'general', bool $isPublic = false): void
    {
        $type = match(true) {
            is_bool($value) => 'boolean',
            is_int($value) => 'integer',
            is_array($value) => 'array',
            default => 'string',
        };
        
        $value = match($type) {
            'array' => json_encode($value),
            default => (string) $value,
        };
        
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'is_public' => $isPublic,
            ]
        );
    }
}