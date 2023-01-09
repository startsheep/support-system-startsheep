<?php

namespace App\Http\Controllers;

use App\Http\Resources\Ticket\TicketStatusCollection;
use App\Http\Searches\Ticket\TicketStatusSearch;
use Illuminate\Http\Request;

class TicketStatusController extends Controller
{
    public function index(Request $request)
    {
        $factory = app()->make(TicketStatusSearch::class);
        $ticketStatuses = $factory->apply()->paginate($request->per_page);

        return new TicketStatusCollection($ticketStatuses);
    }
}
