<?php

namespace App\Http\Searches\Ticket;

use App\Http\Searches\Filters\TicketStatus\Project;
use App\Http\Searches\Filters\TicketStatus\Without;
use App\Http\Searches\HttpSearch;
use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Model;

class TicketStatusSearch extends HttpSearch
{

    protected function passable()
    {
        return TicketStatus::query();
    }

    protected function filters(): array
    {
        return [
            Without::class,
        ];
    }

    protected function thenReturn($ticketStatusSearch)
    {
        return $ticketStatusSearch;
    }
}
