<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    use TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'status' => 'To Do',
                'color' => 'btn-outline-primary',
            ],
            [
                'status' => 'In Progress',
                'color' => 'btn-outline-warning',
            ],
            [
                'status' => 'Merged',
                'color' => 'btn-outline-success',
            ],
            [
                'status' => 'Deployed',
                'color' => 'btn-outline-success',
            ],
            [
                'status' => 'Review',
                'color' => 'btn-outline-info',
            ],
            [
                'status' => 'Done',
                'color' => 'btn-outline-success',
            ],
            [
                'status' => 'Closed',
                'color' => 'btn-outline-danger',
            ],
        ];

        $this->truncate('ticket_statuses');

        foreach ($statuses as $status) {
            TicketStatus::create([
                'status' => $status['status'],
                'color' => $status['color'],
            ]);
        }
    }
}
