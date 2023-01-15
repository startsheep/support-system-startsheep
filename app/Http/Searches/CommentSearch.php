<?php

namespace App\Http\Searches;

use App\Http\Searches\Filters\Comment\Sort;
use App\Http\Searches\Filters\Comment\Ticket;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class CommentSearch extends HttpSearch
{

    protected function passable()
    {
        return Comment::with(['ticket', 'user.roles', 'files']);
    }

    protected function filters(): array
    {
        return [
            Ticket::class,
            Sort::class
        ];
    }

    protected function thenReturn($commentSearch)
    {
        return $commentSearch;
    }
}
