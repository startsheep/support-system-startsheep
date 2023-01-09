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
                'count_customer' => $project->countCustomer(),
                'count_ticket' => $project->countTicket(),
                'created_at' => $project->created_at,
                'updated_at' => $project->updated_at,
                'deleted_at' => $project->deleted_at,
            ];
        }

        return $data;
    }
}
