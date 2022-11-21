<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Database\Seeders\Traits\DisableForeignKey;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    use TruncateTable, DisableForeignKey;

    protected $model;

    public function __construct(Ticket $model)
    {
        $this->model = $model;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate($this->model->getTable());

        $tickets = [
            [
                'code' => 'S-001',
                'title' => 'Ticket 1',
                'company' => 'Company 1',
                'project' => 'Project 1',
                'domain' => 'project.satu.com',
                'description' => 'bug',
                'created_by' => 'PIC Project Satu',
            ],
            [
                'code' => 'S-002',
                'title' => 'Ticket 2',
                'company' => 'Company 2',
                'project' => 'Project 2',
                'domain' => 'project.dua.com',
                'description' => 'bug',
                'created_by' => 'PIC Project Dua',
            ],
            [
                'code' => 'S-003',
                'title' => 'Ticket 3',
                'company' => 'Company 3',
                'project' => 'Project 3',
                'domain' => 'project.tiga.com',
                'description' => 'bug',
                'created_by' => 'PIC Project Tiga',
            ],
            [
                'code' => 'S-004',
                'title' => 'Ticket 4',
                'company' => 'Company 1',
                'project' => 'Project 1',
                'domain' => 'project.satu.com',
                'description' => 'bug',
                'created_by' => 'PIC Project Satu',
            ],
            [
                'code' => 'S-005',
                'title' => 'Ticket 5',
                'company' => 'Company 1',
                'project' => 'Project 1',
                'domain' => 'project.satu.com',
                'description' => 'bug',
                'created_by' => 'PIC Project Satu',
            ],
        ];

        $this->disableForeignKeys();
        foreach ($tickets as $ticket) {
            $this->model->create($ticket);
        }
        $this->enableForeignKeys();
    }
}
