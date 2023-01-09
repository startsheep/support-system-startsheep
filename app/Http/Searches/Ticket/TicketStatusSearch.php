<?php

namespace App\Http\Searches\Ticket;

use App\Http\Searches\HttpSearch;
use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Model;

class TicketStatusSearch extends HttpSearch
{

    protected function passable()
    {
        return TicketStatus::with(['ticket']);
    }

    protected function filters(): array
    {
        return [];
    }

    protected function thenReturn($ticketStatusSearch)
    {
        return $ticketStatusSearch;
    }
}
