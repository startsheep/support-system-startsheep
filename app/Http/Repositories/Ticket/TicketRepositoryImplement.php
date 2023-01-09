<?php

namespace App\Http\Repositories\Ticket;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Ticket;

class TicketRepositoryImplement extends Eloquent implements TicketRepository
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

    public function findByCriteria(array $criteria): ?Ticket
    {
        return $this->model->where($criteria)->first();
    }

    public function getWhereIn(array $data)
    {
        return $this->model->whereIn('id', $data);
    }

    public function codeTicket()
    {
        $number = '001';
        $ticket = $this->model->orderBy('id', 'desc')->first();
        if ($ticket) {
            $number = sprintf("%03d", $ticket->id + 1);
        }

        return 'S-' . $number;
    }
}
