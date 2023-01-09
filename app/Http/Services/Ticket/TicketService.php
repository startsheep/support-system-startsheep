<?php

namespace App\Http\Services\Ticket;

use LaravelEasyRepository\BaseService;

interface TicketService extends BaseService
{
    public function multipleDestroy(array $deleted_data);
}
