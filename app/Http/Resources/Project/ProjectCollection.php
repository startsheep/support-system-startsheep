<?php

namespace App\Http\Resources\Project;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];

        foreach ($this->collection as $project) {
            $data[] = [
                'id' => $project->id,
                'project_name' => $project->project_name,
                'project_domain' => $project->project_domain,
                'count_customer' => $this->countCustomer($project),
                'created_at' => $project->created_at,
                'updated_at' => $project->updated_at,
                'deleted_at' => $project->deleted_at,
            ];
        }

        return $data;
    }

    protected function countCustomer($project)
    {
        $user = [];
        foreach ($project->userHasProject as $userHasProject) {
            if ($userHasProject->user->hasRole(User::ROLE_CUSTOMER)) {
                $user[] = $userHasProject->user;
            }
        }

        return count($user);
    }
}
