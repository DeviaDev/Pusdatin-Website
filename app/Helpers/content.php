<?php
use App\Models\SiteContent;

if (! function_exists('content')) {
    /** Ambil konten website (dikelola admin via /admin/konten). */
    function content(string $key, string $default = ''): string
    {
        return SiteContent::get($key, $default);
    }
}
