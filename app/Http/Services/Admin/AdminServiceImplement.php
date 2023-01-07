<?php

namespace App\Http\Services\Admin;

use LaravelEasyRepository\Service;
use App\Http\Repositories\User\UserRepository;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class AdminServiceImplement extends Service implements AdminService
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
        $role = Role::where('id', User::ROLE_ADMIN)->first();

        $attributes['password'] = Str::random(8);

        $user = $this->mainRepository->create($attributes);
        $user->assignRole($role);

        return $user;
    }
}
