<?php

namespace App\Http\Searches\Filters\User;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;

class Mention implements FilterContract
{
    /** @var string|null */
    protected $mention;

    /**
     * @param string|null $mention
     * @return void
     */
    public function __construct($mention)
    {
        $this->mention = $mention;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        if ($this->keyword() != 'is_mention') {
            return $next($query);
        }

        $query->where('name', 'like', '%' . request('search') . '%');

        return $next($query);
    }

    /**
     * Get mention keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->mention) {
            return $this->mention;
        }

        $this->mention = request('mention', null);

        return request('mention');
    }
}
