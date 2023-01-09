<?php

namespace App\Http\Searches\Filters\Ticket;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Searches\Contracts\FilterContract;

class Project implements FilterContract
{
    /** @var string|null */
    protected $project;

    /**
     * @param string|null $project
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function handle(Builder $query, Closure $next)
    {
        if (!$this->keyword()) {
            return $next($query);
        }

        $query->where('project_id', $this->keyword());

        return $next($query);
    }

    /**
     * Get project keyword.
     *
     * @return mixed
     */
    protected function keyword()
    {
        if ($this->project) {
            return $this->project;
        }

        $this->project = request('project', null);

        return request('project');
    }
}
