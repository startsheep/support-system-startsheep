<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            ProjectSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            // TicketSeeder::class,
            TicketStatusSeeder::class
        ]);
    }
}
