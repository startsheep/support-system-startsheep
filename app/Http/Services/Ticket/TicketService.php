<?php

namespace App\Http\Services\Ticket;

use LaravelEasyRepository\BaseService;

interface TicketService extends BaseService
{
    public function multipleDestroy(array $deleted_data);

    public function resolve(array $data);

    public function updateStatus($id, array $data);

    public function assignTo(array $data);

    public function getWhereIn(array $data);
}
