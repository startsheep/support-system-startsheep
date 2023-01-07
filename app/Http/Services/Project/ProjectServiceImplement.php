<?php

namespace App\Http\Services\Project;

use LaravelEasyRepository\Service;
use App\Http\Repositories\Project\ProjectRepository;
use App\Models\Project;

class ProjectServiceImplement extends Service implements ProjectService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(ProjectRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function delete($id)
    {
        $project = $this->mainRepository->findOrFail($id);
        if ($project->userHasProject) {
            $project->userHasProject()->delete();
        }

        $project->delete();

        return $project;
    }
}
