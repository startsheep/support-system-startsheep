<?php

namespace App\Http\Searches\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Builder;

interface FilterContract
{
    /**
     * handle query assignment
     *
     * @return mixed
     */
    public function handle(Builder $query, Closure $next);
}
