<?php

namespace App\Http\Traits;

use App\Observers\CreatedByObserver;

trait EntryAutomation
{
    public static function bootEntryAutomation()
    {
        static::observe(CreatedByObserver::class);
    }
}
