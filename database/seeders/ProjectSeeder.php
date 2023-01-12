<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = ["Project 1", "Project 2", "Project 3", "Project 4", "Project 5", "Project 6", "Project 7", "Project 8", "Project 9", "Project 10"];

        foreach ($projects as $project) {
            Project::create([
                'project_name' => $project,
                'project_domain' => "http://" . Str::slug($project) . ".com",
            ]);
        }
    }
}
