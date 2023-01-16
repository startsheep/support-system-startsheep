<?php

namespace App\Http\Searches\Filters\TicketStatus;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;
use App\Models\TicketStatus;

class Without implements FilterContract
{
    /** @var string|null */
    protected $without;

    /**
     * @param string|null $without
     * @return void
     */
    public function __construct($without)
    {
        $this->without = $without;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }
        $query->with(['tickets.staff']);

        $status = TicketStatus::where('status', 'LIKE', '%' . $this->without . '%')->pluck('id');

        $query->whereNotIn('id', $status);

        return $next($query);
    }

    /**
     * Get without keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->without) {
            return $this->without;
        }

        $this->without = request('without', null);

        return request('without');
    }
}
