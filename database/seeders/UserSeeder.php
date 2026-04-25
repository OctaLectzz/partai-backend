<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin user
        User::factory()->create([
            'name' => 'Admin System',
            'email' => 'admin@partai.com',
            'role' => 'admin',
            'status' => true,
        ]);

        // Create a Board Member
        User::factory()->create([
            'name' => 'Pengurus Pusat',
            'email' => 'pengurus@partai.com',
            'role' => 'board_member',
            'status' => true,
        ]);

        // Create a regular Member
        User::factory()->create([
            'name' => 'Anggota Biasa',
            'email' => 'anggota@partai.com',
            'role' => 'member',
            'status' => true,
        ]);

        // Generate 50 random users for other roles and statuses
        User::factory(50)->create();
    }
}
