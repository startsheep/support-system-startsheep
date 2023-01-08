<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Customer\CreateRequest;
use App\Http\Requests\User\Customer\UpdateRequest;
use App\Http\Resources\User\Customer\CustomerCollection;
use App\Http\Resources\User\Customer\CustomerDetail;
use App\Http\Searches\User\CustomerSearch;
use App\Http\Services\Customer\CustomerService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    protected $userService;

    public function __construct(CustomerService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $factory = app()->make(CustomerSearch::class);
        $customers = $factory->apply()->paginate($request->per_page);

        return new CustomerCollection($customers);
    }

    public function store(CreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return $this->userService->create($request->all());
        });
    }

    public function show($id)
    {
        $customer = $this->userService->find($id);
        if (!$customer->hasRole(User::ROLE_CUSTOMER)) {
            abort(404);
        }

        return new CustomerDetail($customer);
    }

    public function update($id, UpdateRequest $request)
    {
        return DB::transaction(function () use ($id, $request) {
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
