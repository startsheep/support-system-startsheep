<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Open', 'On Hold', 'On Progress', 'Closed', 'Done'];

        foreach ($statuses as $status) {
            TicketStatus::create([
                'status' => $status,
            ]);
        }
    }
}
