<?php

namespace App\Http\Searches;

use App\Http\Searches\Filters\Ticket\Project;
use App\Http\Searches\Filters\Ticket\Search;
use App\Http\Searches\Filters\Ticket\Sort;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketSearch extends HttpSearch
{

    protected function passable()
    {
        return Ticket::with(['files', 'createdBy', 'project', 'staff', 'ticketStatus']);
    }

    protected function filters(): array
    {
        return [
            Search::class,
            Sort::class,
            Project::class,
        ];
    }

    protected function thenReturn($ticketSearch)
    {
        return $ticketSearch;
    }
}
