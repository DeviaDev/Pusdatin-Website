<?php
use App\Models\SiteContent;

if (! function_exists('content')) {
    function content(string $key, string $default = ''): string
    {
        return SiteContent::get($key, $default);
    }
}
