<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::factory()->create([
            'name' => 'Çatalköy',
            'parent_id' => null
        ]);
        Location::factory()->create([
            'name' => 'Esentepe',
            'parent_id' => null
        ]);

        Location::factory(20)->create();
    }
}
