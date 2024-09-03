<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\ApplicationAssignment;
use App\Models\ApplicationResponse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Application::factory(10)->create();
        ApplicationAssignment::factory(10)->create();
        ApplicationResponse::factory(10)->create();
    }
}
