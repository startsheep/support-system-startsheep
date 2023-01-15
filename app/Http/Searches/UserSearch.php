<?php

namespace App\Http\Searches;

use App\Http\Searches\Filters\User\Mention;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserSearch extends HttpSearch
{
    protected function passable()
    {
        return User::query();
    }

    protected function filters(): array
    {
        return [
            Mention::class
        ];
    }

    protected function thenReturn($userSearch)
    {
        return $userSearch;
    }
}
