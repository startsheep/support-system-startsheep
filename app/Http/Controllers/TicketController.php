<?php

namespace App\Http\Controllers;

use App\Events\TicketMessage;
use App\Http\Requests\Ticket\CreateRequest;
use App\Http\Requests\Ticket\UpdateRequest;
use App\Http\Resources\Ticket\TicketCollection;
use App\Http\Resources\Ticket\TicketDetail;
use App\Http\Searches\TicketSearch;
use App\Http\Services\Ticket\TicketService;
use App\Http\Traits\MessageFixer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index(Request $request)
    {
        $factory = app()->make(TicketSearch::class);
        $tickets = $factory->apply()->paginate($request->per_page);

        return new TicketCollection($tickets);
    }

    public function store(CreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            return $this->ticketService->create($request->all());
        });
    }

    public function show($id)
    {
        $ticket = $this->ticketService->findOrFail($id);

        return new TicketDetail($ticket);
    }

    public function update(UpdateRequest $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            return $this->ticketService->update($id, $request->all());
        });
    }

    public function assignTo(Request $request)
    {
        return DB::transaction(function () use ($request) {
            return $this->ticketService->assignTo($request->all());
        });
    }

    public function resolve(Request $request)
    {
        return DB::transaction(function () use ($request) {
            return $this->ticketService->resolve($request->resolved_data);
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->ticketService->delete($id);
        });
    }

    public function multipleDestroy(Request $request)
    {
        return DB::transaction(function () use ($request) {
            TicketMessage::dispatch("Multiple Ticket Deleted");
            return $this->ticketService->destroy($request->deleted_data);
        });
    }
}
