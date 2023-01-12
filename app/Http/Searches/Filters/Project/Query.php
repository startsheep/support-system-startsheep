<?php

namespace App\Http\Searches\Filters\Project;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Query implements FilterContract
{
    /** @var string|null */
    protected $query;

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        $user = auth()->user();

        if ($user->hasRole([User::ROLE_STAFF, User::ROLE_CUSTOMER])) {
            $query->whereHas('userHasProject', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

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
