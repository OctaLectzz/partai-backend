<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CouncilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create([
            'kta_number' => now()->format('Ymd').str_pad(User::count() + 1, 4, '0', STR_PAD_LEFT),
            'role' => 'council',
            'type' => 'admin',
        ]);
    }
}
