<?php

namespace App\Http\Searches;

use App\Http\Searches\Filters\Project\Query;
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
            Query::class
        ];
    }

    protected function thenReturn($projectSearch)
    {
        return $projectSearch;
    }
}
