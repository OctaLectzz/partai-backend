<?php

namespace Database\Seeders;

use App\Models\Kta;
use Illuminate\Database\Seeder;

class KtaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kta::factory()->count(20)->create();
    }
}
