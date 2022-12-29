<?php

namespace App\Traits;

use Spatie\ResponseCache\Facades\ResponseCache;

trait ClearsResponseCache
{
    public static function bootClearsResponseCache()
    {
        static::created(function () {
            ResponseCache::clear();
        });
        static::updated(function () {
            ResponseCache::clear();
        });
        static::deleted(function () {
            ResponseCache::clear();
        });
    }
}
