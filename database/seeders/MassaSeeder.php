<?php

namespace Database\Seeders;

use App\Models\Massa;
use Illuminate\Database\Seeder;

class MassaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific massa records with full data
        Massa::factory()->create([
            'nik' => '3201010101010001',
            'full_name' => 'Ahmad Suryadi',
            'gender' => 'M',
            'place_of_birth' => 'Jakarta',
            'date_of_birth' => '1985-03-15',
            'phone_number' => '081234567890',
            'email' => 'ahmad.suryadi@email.com',
            'address' => 'Jl. Merdeka No. 10',
            'rt' => '001',
            'rw' => '002',
            'postal_code' => '10110',
            'profession' => 'Wiraswasta',
            'status' => 'active',
        ]);

        Massa::factory()->create([
            'nik' => '3201010101010002',
            'full_name' => 'Siti Nurhaliza',
            'gender' => 'F',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '1990-07-22',
            'phone_number' => '082198765432',
            'email' => 'siti.nurhaliza@email.com',
            'address' => 'Jl. Asia Afrika No. 55',
            'rt' => '003',
            'rw' => '005',
            'postal_code' => '40111',
            'profession' => 'Guru',
            'status' => 'active',
        ]);

        Massa::factory()->create([
            'nik' => '3201010101010003',
            'full_name' => 'Budi Santoso',
            'gender' => 'M',
            'place_of_birth' => 'Surabaya',
            'date_of_birth' => '1978-11-05',
            'phone_number' => '085312345678',
            'email' => 'budi.santoso@email.com',
            'address' => 'Jl. Tunjungan No. 88',
            'rt' => '010',
            'rw' => '003',
            'postal_code' => '60271',
            'profession' => 'Pedagang',
            'status' => 'inactive',
        ]);

        // Generate 100 random massa records
        Massa::factory(100)->active()->create();

        // Generate 20 inactive records
        Massa::factory(20)->inactive()->create();
    }
}
