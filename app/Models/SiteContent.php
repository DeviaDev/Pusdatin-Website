<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteContent extends Model
{
    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    /** Ambil konten by key, fallback ke default bila belum ada. */
    public static function get(string $key, string $default = ''): string
    {
        return Cache::rememberForever('site_content:' . $key, function () use ($key, $default) {
            return static::where('key', $key)->value('value') ?? $default;
        });
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_content:' . $key);
    }
}
