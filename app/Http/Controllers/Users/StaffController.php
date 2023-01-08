<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Staff\CreateRequest;
use App\Http\Requests\User\Staff\UpdateRequest;
use App\Http\Resources\User\Staff\StaffCollection;
use App\Http\Resources\User\Staff\StaffDetail;
use App\Http\Searches\User\StaffSearch;
use App\Http\Services\Staff\StaffService;
use App\Http\Services\User\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    protected $userService;

    public function __construct(StaffService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $factory = app()->make(StaffSearch::class);
        $staff = $factory->apply()->paginate($request->per_page);

        return new StaffCollection($staff);
    }

    public function store(CreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return $this->userService->create($request->all());
        });
    }

    public function show($id)
    {
        $staff = $this->userService->find($id);
        if (!$staff->hasRole(User::ROLE_STAFF)) {
            abort(404);
        }

        return new StaffDetail($staff);
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
