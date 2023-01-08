<?php

namespace App\Http\Searches\User;

use App\Http\Searches\Filters\User\Customer\Role;
use App\Http\Searches\Filters\User\Search;
use App\Http\Searches\HttpSearch;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CustomerSearch extends HttpSearch
{

    protected function passable()
    {
        return User::with(['customerHasProject.project', 'roles']);
    }

    protected function filters(): array
    {
        return [
            Role::class,
            Search::class
        ];
    }

    protected function thenReturn($customerSearch)
    {
        return $customerSearch;
    }
}
