<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Admin\CreateRequest;
use App\Http\Requests\User\Admin\UpdateRequest;
use App\Http\Resources\User\Admin\AdminCollection;
use App\Http\Resources\User\Admin\AdminDetail;
use App\Http\Searches\User\AdminSearch;
use App\Http\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $factory = app()->make(AdminSearch::class);
        $admins = $factory->apply()->paginate($request->per_page);

        return new AdminCollection($admins);
    }

    public function store(CreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return $this->userService->create($request->all());
        });
    }

    public function show($id)
    {
        $admin = $this->userService->find($id);

        return new AdminDetail($admin);
    }

    public function update(UpdateRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            return $this->userService->update($id, $request->all());
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->userService->delete($id);
        });
    }
}
