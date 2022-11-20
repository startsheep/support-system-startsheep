<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

/**
 * Helpers
 */
trait Helpers
{
    public function title($value)
    {
        return Str::remove(' ', ucwords(Str::of($value)->replace('_', ' ')));
    }
}
