<?php

namespace App\Http\Repositories\AdminDashboard;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\AdminDashboard;
use App\Models\Ticket;
use App\Models\TicketStatus;

class AdminDashboardRepositoryImplement extends Eloquent implements AdminDashboardRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $totalTickets = $this->model->count();
        $openTickets = $this->model->where('ticket_status', TicketStatus::OPEN)->count();
        $closedTickets = $this->model->where('ticket_status', TicketStatus::CLOSED)->count();
        $unresolvedTickets = $this->model->whereIn('ticket_status', [
            TicketStatus::IN_PROGRESS,
            TicketStatus::MERGED,
            TicketStatus::DEPLOYED,
            TicketStatus::REVIEW,
        ])->count();
        $resolvedTickets = $this->model->where('ticket_status', TicketStatus::DONE)->count();
        $unassignedTickets = $this->model->where('staff_id', null)->count();

        return [
            'total_tickets' => $totalTickets,
            'open_tickets' => $openTickets,
            'closed_tickets' => $closedTickets,
            'unresolved_tickets' => $unresolvedTickets,
            'resolved_tickets' => $resolvedTickets,
            'unassigned_tickets' => $unassignedTickets,
        ];
    }
}
