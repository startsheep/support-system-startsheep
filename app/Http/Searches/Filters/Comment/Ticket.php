<?php

namespace App\Http\Searches\Filters\Comment;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;

class Ticket implements FilterContract
{
    /** @var string|null */
    protected $ticket;

    /**
     * @param string|null $ticket
     * @return void
     */
    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        $query->where('ticket_id', 'LIKE', '%' . $this->ticket . '%');

        return $next($query);
    }

    /**
     * Get ticket keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->ticket) {
            return $this->ticket;
        }

        $this->ticket = request('ticket', null);

        return request('ticket');
    }
}
