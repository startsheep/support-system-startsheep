<?php

namespace App\Http\Services\Staff;

use App\Http\Repositories\Project\ProjectRepository;
use LaravelEasyRepository\Service;
use App\Http\Repositories\Staff\StaffRepository;
use App\Http\Repositories\User\UserRepository;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class StaffServiceImplement extends Service implements StaffService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(UserRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function create($attributes)
    {
        $role = Role::where('id', User::ROLE_STAFF)->first();

        $attributes['password'] = Str::random(8);

        $user = $this->mainRepository->create($attributes);
        $user->assignRole($role);

        $this->assignToProject($user, $attributes);

        return $user;
    }

    public function find($id)
    {
        $user = $this->mainRepository->findOrFail($id);
        $user->load(['staffHasProject.project', 'roles']);

        return $user;
    }

    public function update($id, $attributes)
    {
        $user = $this->mainRepository->findOrFail($id);
        $user->update($attributes);

        $this->updateAssignProject($user, $attributes);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->mainRepository->findOrFail($id);
        if ($user->staffHasProject) {
            $user->staffHasProject()->delete();
        }

        $user->delete();

        return $user;
    }

    public function assignToProject($user, $attributes)
    {
        return $user->staffHasProject()->create([
            'project_id' => $attributes['project_id']
        ]);
    }

    public function updateAssignProject($user, $attributes)
    {
        return $user->staffHasProject()->update([
            'project_id' => $attributes['project_id']
        ]);
    }
}