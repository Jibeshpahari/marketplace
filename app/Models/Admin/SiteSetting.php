<?php

namespace App\Models\Admin;

use App\Enums\SettingKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    protected $fillable = ['key', 'value', 'type', 'group'];

    // protected static function booted(): void
    // {
    //     static::saved(fn () => Cache::forget('settings'));
    //     static::deleted(fn () => Cache::forget('settings'));
    // }

    public static function get(SettingKey|string $key, mixed $default = null): mixed
    {
        $key = $key instanceof SettingKey ? $key->value : $key;

        // $settings = Cache::rememberForever('settings', function () {
        //     return static::all()
        //         ->keyBy('key')
        //         ->map(fn ($setting) => [
        //             'value' => $setting->value,
        //             'type' => $setting->type,
        //         ])
        //         ->toArray();
        // });

        // Temporary: direct DB read, no cache, for testing 
        $setting = static::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => (bool) $setting->value,
            'integer' => (int) $setting->value,
            'json', 'array' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    public static function set(SettingKey|string $key, mixed $value, string $type = 'string', string $group = 'general'): void
    {
        $key = $key instanceof SettingKey ? $key->value : $key;

        if (is_array($value)) {
            $value = json_encode($value);
            $type = 'json';
        } elseif (is_bool($value)) {
            $value = $value ? '1' : '0';
            $type = 'boolean';
        }

        static::updateOrCreate(['key' => $key], compact('value', 'type', 'group'));
    }
}
