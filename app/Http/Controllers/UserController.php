<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Searches\UserSearch;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke(Request $request)
    {
        $factory = app()->make(UserSearch::class);
        $users = $factory->apply()->paginate($request->per_page);

        return new UserCollection($users);
    }
}
