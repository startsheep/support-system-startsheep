<?php

namespace App\Http\Searches\Filters\Comment;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;

class Sort implements FilterContract
{
    /** @var string|null */
    protected $sort;

    /**
     * @param string|null $sort
     * @return void
     */
    public function __construct($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        $sortField = request('order_by', request()->order_by ? request()->order_by : 'id');
        $sortOrder = request('order_direction', request()->order_direction ? request()->order_direction : 'desc');

        $query->orderBy($sortField, $sortOrder);

        return $next($query);
    }

    /**
     * Get sort keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->sort) {
            return $this->sort;
        }

        $this->sort = request('sort', null);

        return request('sort');
    }
}
