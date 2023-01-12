<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserHasProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mailist = ["admin@mailinator.com", "staff@mailinator.com", "customer@mailinator.com"];

        foreach ($mailist as $email) {
            $user = User::factory()->create([
                'email' => $email,
            ]);
        }

        UserHasProject::create([
            'user_id' => 2,
            'project_id' => 1,
        ]);

        UserHasProject::create([
            'user_id' => 3,
            'project_id' => 1,
        ]);
    }
}
