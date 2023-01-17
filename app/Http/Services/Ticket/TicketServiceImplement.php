<?php

namespace App\Http\Services\Ticket;

use LaravelEasyRepository\Service;
use App\Http\Repositories\Ticket\TicketRepository;
use App\Http\Traits\SendEmail;
use App\Models\TicketStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketServiceImplement extends Service implements TicketService
{
    use SendEmail;

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(TicketRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function getWhereIn(array $data)
    {
        $tickets = $this->mainRepository->getWhereIn($data)->get();
        $tickets->load(['files', 'createdBy', 'staff', 'project', 'ticketStatus']);

        return $tickets;
    }

    public function create($attributes)
    {
        $attributes['ticket_code'] = $this->mainRepository->codeTicket();
        $attributes['ticket_status'] = TicketStatus::OPEN;

        $ticket = $this->mainRepository->create($attributes);

        if (isset($attributes['files']) && $attributes['files']) {
            $this->multipleUpload($attributes['files'], $ticket);
        }

        return $ticket;
    }

    public function findOrFail($id)
    {
        $ticket = $this->mainRepository->findOrFail($id);
        $ticket->load(['files', 'createdBy', 'staff', 'project', 'ticketStatus']);

        return $ticket;
    }

    public function find($code)
    {
        $ticket = $this->mainRepository->findByCriteria(['code' => $code]);
        $ticket->files;

        return $ticket;
    }

    public function update($id, $attributes)
    {
        $ticket = DB::transaction(function () use ($id, $attributes) {
            $ticket = parent::findOrFail($id);

            if (isset($attributes['files']) && $attributes['files']) {
                if ($ticket->files) {
                    foreach ($ticket->files as $file) {
                        Storage::delete($file->file_path);
                    }

                    $ticket->files()->delete();
                }

                $this->multipleUpload($attributes['files'], $ticket);
            }

            if ($attributes['staff_id']) {
                $tickets = $this->mainRepository->getWhereIn([$id]);
                $this->sendEmailAssignTo($tickets, $attributes['staff_id']);
            }

            return $ticket->update($attributes);
        });

        return $ticket;
    }

    public function delete($id)
    {
        $ticket = parent::findOrFail($id);
        if ($ticket->files) {
            foreach ($ticket->files as $file) {
                Storage::delete($file->file_path);
            }

            $ticket->files()->delete();
        }

        return $ticket->delete();
    }

    public function multipleDestroy(array $deleted_data)
    {
        $tickets = $this->mainRepository->getWhereIn($deleted_data);

        return $tickets->update(['ticket_status' => TicketStatus::CLOSED]);
    }

    public function resolve(array $data)
    {
        $tickets = $this->mainRepository->getWhereIn($data);

        return $tickets->update(['ticket_status' => TicketStatus::DONE]);
    }

    public function assignTo(array $data)
    {
        $tickets = $this->mainRepository->getWhereIn($data['assigned_data']);

        $this->sendEmailAssignTo($tickets, $data['staff_id']);

        return $tickets->update(['staff_id' => $data['staff_id']]);
    }

    public function updateStatus($id, array $data)
    {
        $tickets = parent::findOrFail($id);

        return $tickets->update(['ticket_status' => $data['ticket_status']]);
    }

    protected function multipleUpload($files, $ticket)
    {
        foreach ($files as $file) {
            $file = $this->storageFile($file, 'tickets');
            $ticket->files()->create($file);
        }
    }

    public function storageFile($file, $folder)
    {
        $path = $file->store($folder);

        return [
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
        ];
    }
}
