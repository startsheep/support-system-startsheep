<?php

namespace App\Http\Searches;

use App\Http\Searches\Filters\Ticket\Search;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TicketSearch extends HttpSearch
{

    protected function passable()
    {
        return Ticket::with('files');
    }

    protected function filters(): array
    {
        return [
            Search::class
        ];
    }

    protected function thenReturn($ticketSearch)
    {
        return $ticketSearch;
    }
}
