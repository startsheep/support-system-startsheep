<?php

namespace App\Http\Repositories\Project;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Project;

class ProjectRepositoryImplement extends Eloquent implements ProjectRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
