<?php

namespace App\Http\Repositories\StaffDashboard;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\StaffDashboard;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\Auth;

class StaffDashboardRepositoryImplement extends Eloquent implements StaffDashboardRepository
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
        $totalTickets = $this->model->where('staff_id', auth()->user()->id)->count();
        $openTickets = $this->model->where('staff_id', auth()->user()->id)->where('ticket_status', TicketStatus::OPEN)->count();
        $closedTickets = $this->model->where('staff_id', auth()->user()->id)->where('ticket_status', TicketStatus::CLOSED)->count();
        $unresolvedTickets = $this->model->where('staff_id', auth()->user()->id)->whereIn('ticket_status', [
            TicketStatus::IN_PROGRESS,
            TicketStatus::MERGED,
            TicketStatus::DEPLOYED,
            TicketStatus::REVIEW,
        ])->count();
        $resolvedTickets = $this->model->where('staff_id', auth()->user()->id)->where('ticket_status', TicketStatus::DONE)->count();

        return [
            'total_tickets' => $totalTickets,
            'open_tickets' => $openTickets,
            'closed_tickets' => $closedTickets,
            'unresolved_tickets' => $unresolvedTickets,
            'resolved_tickets' => $resolvedTickets,
        ];
    }
}
