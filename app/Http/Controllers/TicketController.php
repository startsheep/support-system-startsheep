<?php

namespace App\Http\Controllers;

use App\Events\CreateTicketMessage;
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

        if ($request->isAll == 'true') {
            $tickets = $factory->apply()->get();
        }

        return new TicketCollection($tickets);
    }

    public function store(CreateRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $ticket = $this->ticketService->create($request->all());
            $ticket->load(['files', 'createdBy', 'staff', 'project', 'ticketStatus']);
            CreateTicketMessage::dispatch($ticket);
            return $ticket;
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
            $ticket = $this->ticketService->update($id, $request->all());
            TicketMessage::dispatch($this->ticketService->findOrFail($id));
            return $ticket;
        });
    }

    public function assignTo(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $tickets = $this->ticketService->assignTo($request->all());
            foreach ($request->assigned_data as $id) {
                TicketMessage::dispatch($this->ticketService->findOrFail($id));
            }
            return $tickets;
        });
    }

    public function resolve(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $tickets = $this->ticketService->resolve($request->resolved_data);
            foreach ($request->resolved_data as $id) {
                TicketMessage::dispatch($this->ticketService->findOrFail($id));
            }
            return $tickets;
        });
    }

    public function updateStatus(Request $request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $ticket = $this->ticketService->updateStatus($id, $request->all());
            TicketMessage::dispatch($this->ticketService->findOrFail($id));
            return $ticket;
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            TicketMessage::dispatch("Ticket Deleted");
            return $this->ticketService->delete($id);
        });
    }

    public function multipleDestroy(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $tickets = $this->ticketService->destroy($request->deleted_data);
            foreach ($request->deleted_data as $id) {
                TicketMessage::dispatch([
                    'message' => "deleted",
                    'id' => $id
                ]);
            }
            return $tickets;
        });
    }
}
