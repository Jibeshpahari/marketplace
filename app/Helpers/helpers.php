<?php

use App\Enums\SettingKey;
use App\Models\Admin\SiteSetting;

/**
 * Single entry point: checks route name match (exact or wildcard)
 * and URL path match (for slash-based wildcards), so you only ever
 * call this one function from your views.
 *
 * Usage in blade:
 *   isActive('products.catalogue')   -> exact route name
 *   isActive('products.*')           -> wildcard route name (parent)
 *   isActive('products/*')           -> wildcard URL path (parent, alt format)
 */
function isActive($patterns): bool
{
    foreach ((array) $patterns as $pattern) {
        if (routePatternMatches($pattern)) {
            return true;
        }
    }
    return false;
}

/**
 * Internal helper — not used directly in views.
 * Decides whether the pattern is a route-name pattern or a URL-path pattern,
 * then runs the matching check.
 */
function routePatternMatches(string $pattern): bool
{
    // If it contains a slash, treat it as a URL path pattern (e.g. "products/*")
    if (str_contains($pattern, '/')) {
        return request()->is($pattern);
    }

    // Otherwise treat it as a route name pattern (e.g. "products.*" or "products.catalogue")
    return request()->routeIs($pattern);
}

if (! function_exists('setting')) {
    function setting(SettingKey|string $key, mixed $default = null): mixed
    {
        return SiteSetting::get($key, $default);
    }
}