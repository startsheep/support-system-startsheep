<?php

namespace App\Http\Searches\Filters\Ticket;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;

class Search implements FilterContract
{
    /** @var string|null */
    protected $search;

    /**
     * @param string|null $search
     * @return void
     */
    public function __construct($search)
    {
        $this->search = $search;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        $query->where(function ($ticketSearch) {
            $ticketSearch->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('company', 'like', '%' . $this->search . '%')
                ->orWhere('project', 'like', '%' . $this->search . '%')
                ->orWhere('created_by', 'like', '%' . $this->search . '%');
        });

        return $next($query);
    }

    /**
     * Get search keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->search) {
            return $this->search;
        }

        $this->search = request('search', null);

        return request('search');
    }
}
