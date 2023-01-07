<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\Project\ProjectCollection;
use App\Http\Resources\Project\ProjectDetail;
use App\Http\Searches\ProjectSearch;
use App\Http\Services\Project\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        $factory = app(ProjectSearch::class);
        $projects = $factory->apply()->paginate($request->per_page);

        return new ProjectCollection($projects);
    }

    public function store(ProjectRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return $this->projectService->create($request->all());
        });
    }

    public function show($id)
    {
        $project = $this->projectService->findOrFail($id);

        return new ProjectDetail($project);
    }

    public function update(ProjectRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            return $this->projectService->update($id, $request->all());
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->projectService->delete($id);
        });
    }
}
