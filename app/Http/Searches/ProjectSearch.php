<?php

namespace App\Http\Searches;

use App\Http\Searches\Filters\Project\Query;
use App\Http\Searches\Filters\Project\Search;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class ProjectSearch extends HttpSearch
{

    protected function passable()
    {
        return Project::query();
    }

    protected function filters(): array
    {
        return [
            Query::class,
            Search::class
        ];
    }

    protected function thenReturn($projectSearch)
    {
        return $projectSearch;
    }
}
