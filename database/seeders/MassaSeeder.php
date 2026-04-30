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
            'place_of_birth' => 'Jakarta Pusat',
            'date_of_birth' => '1985-03-15',
            'phone_number' => '081234567890',
            'email' => 'ahmad.suryadi@email.com',
            'address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
            'rt' => '001',
            'rw' => '002',
            'province_id' => '31',
            'regency_id' => '3171',
            'district_id' => '3171010',
            'village_id' => '3171010001',
            'postal_code' => '10110',
            'latitude' => -6.175,
            'longitude' => 106.828,
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
            'address' => 'Jl. Asia Afrika No. 55, Bandung',
            'rt' => '003',
            'rw' => '005',
            'province_id' => '32',
            'regency_id' => '3273',
            'district_id' => '3273060',
            'village_id' => '3273060001',
            'postal_code' => '40111',
            'latitude' => -6.921,
            'longitude' => 107.610,
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
            'address' => 'Jl. Tunjungan No. 88, Surabaya',
            'rt' => '010',
            'rw' => '003',
            'province_id' => '35',
            'regency_id' => '3578',
            'district_id' => '3578060',
            'village_id' => '3578060001',
            'postal_code' => '60271',
            'latitude' => -7.265,
            'longitude' => 112.742,
            'profession' => 'Pedagang',
            'status' => 'inactive',
        ]);

        // Generate 2500 random massa records
        Massa::factory(2500)->active()->create();

        // Generate 500 inactive records
        Massa::factory(500)->inactive()->create();
    }
}
