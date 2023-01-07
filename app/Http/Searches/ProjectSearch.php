<?php

namespace App\Http\Searches;

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
        return [];
    }

    protected function thenReturn($projectSearch)
    {
        return $projectSearch;
    }
}
