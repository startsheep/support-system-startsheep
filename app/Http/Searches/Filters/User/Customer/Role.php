<?php

namespace App\Http\Searches\Filters\User\Customer;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;
use App\Models\User;

class Role implements FilterContract
{
    /** @var string|null */
    protected $role;

    /**
     * @param string|null $role
     * @return void
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        $query->whereHas('roles', function ($query) {
            $query->where('id', User::ROLE_CUSTOMER);
        });

        return $next($query);
    }

    /**
     * Get role keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->role) {
            return $this->role;
        }

        $this->role = request('role', null);

        return request('role');
    }
}
