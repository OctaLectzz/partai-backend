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
        // Create a Superadmin user
        User::factory()->create([
            'name' => 'Superadmin System',
            'email' => 'superadmin@partai.com',
            'role' => 'superadmin',
            'type' => 'admin',
            'status' => true,
        ]);

        // Create an Admin user
        User::factory()->create([
            'name' => 'Admin System',
            'email' => 'admin@partai.com',
            'role' => 'admin',
            'type' => 'admin',
            'status' => true,
        ]);

        // Create a Council Member (Dewan)
        User::factory()->create([
            'name' => 'Anggota Dewan',
            'email' => 'dewan@partai.com',
            'role' => 'council',
            'type' => 'user',
            'status' => true,
        ]);

        // Create a regular Member
        User::factory()->create([
            'name' => 'Anggota Biasa',
            'email' => 'anggota@partai.com',
            'role' => 'member',
            'type' => 'user',
            'status' => true,
        ]);

        // Generate 50 random users for other roles and statuses
        User::factory(50)->create();
    }
}
