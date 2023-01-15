<?php

namespace App\Http\Services\Customer;

use LaravelEasyRepository\Service;
use App\Http\Repositories\User\UserRepository;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class CustomerServiceImplement extends Service implements CustomerService
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
        $role = Role::where('id', User::ROLE_CUSTOMER)->first();

        $attributes['password'] = Str::random(8);

        $user = $this->mainRepository->create($attributes);
        $user->assignRole($role);

        $this->assignToProject($user, $attributes);

        return $user;
    }

    public function find($id)
    {
        $user = $this->mainRepository->findOrFail($id);
        $user->load(['customerHasProject.project', 'roles']);

        return $user;
    }

    public function update($id, $attributes)
    {
        $user = $this->mainRepository->findOrFail($id);
        $user->update($attributes);

        $user->customerHasProject()->delete();

        $this->assignToProject($user, $attributes);

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
        foreach ($attributes['project_id'] as $projectId) {
            $user->staffHasProject()->create([
                'project_id' => $projectId
            ]);
        }

        return $user;
    }
}
