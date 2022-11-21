<?php

namespace App\Http\Repositories\Ticket;

use Illuminate\Database\Eloquent\Model;
use LaravelEasyRepository\Repository;

interface TicketRepository extends Repository
{
    public function codeTicket();

    public function findByCriteria(array $criteria): ?Model;
}
