<?php

namespace App\Http\Searches\Filters\Project;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;
use Illuminate\Support\Facades\DB;

class Query implements FilterContract
{
    /** @var string|null */
    protected $query;

    /**
     * @param string|null $query
     * @return void
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        return $next($query);
    }

    /**
     * Get query keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->query) {
            return $this->query;
        }

        $this->query = request('query', null);

        return request('query');
    }
}
