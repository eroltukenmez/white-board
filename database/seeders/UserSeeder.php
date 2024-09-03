<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'root@white-board.test',
            'phone' => '5555555555',
            'password' => '123456',
            'status' => true
        ]);
        $user->assignRole('admin');
    }
}
