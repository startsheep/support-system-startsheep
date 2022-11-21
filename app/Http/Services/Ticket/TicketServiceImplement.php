<?php

namespace App\Http\Services\Ticket;

use LaravelEasyRepository\Service;
use App\Http\Repositories\Ticket\TicketRepository;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TicketServiceImplement extends Service implements TicketService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(TicketRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function create($attributes)
    {
        $ticket = DB::transaction(function () use ($attributes) {
            $attributes['code'] = $this->mainRepository->codeTicket();

            $ticket = $this->mainRepository->create($attributes);

            if (isset($attributes['files']) && $attributes['files']) {
                $this->multipleUpload($attributes['files'], $ticket);
            }

            return $ticket;
        });

        return $ticket;
    }

    public function findOrFail($id)
    {
        $ticket = parent::findOrFail($id);
        $ticket->files;

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
