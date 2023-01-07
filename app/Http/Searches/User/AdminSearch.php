<?php

namespace App\Http\Searches\User;

use App\Http\Searches\Filters\User\Admin\Role;
use App\Http\Searches\Filters\User\Search;
use App\Http\Searches\HttpSearch;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdminSearch extends HttpSearch
{

    protected function passable()
    {
        return User::query();
    }

    protected function filters(): array
    {
        return [
            Role::class,
            Search::class
        ];
    }

    protected function thenReturn($adminSearch)
    {
        return $adminSearch;
    }
}
