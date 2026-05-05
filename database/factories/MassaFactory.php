<?php

namespace Database\Factories;

use App\Models\Massa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Massa>
 */
class MassaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locations = [
            [
                'province_id' => '31', // DKI Jakarta
                'regency_id' => '3171', // Jakarta Pusat
                'district_id' => '3171010',
                'village_id' => '3171010001',
                'lat_range' => [-6.20, -6.15],
                'lng_range' => [106.80, 106.84],
                'city_name' => 'Jakarta Pusat',
            ],
            [
                'province_id' => '31',
                'regency_id' => '3174', // Jakarta Barat
                'district_id' => '3174010',
                'village_id' => '3174010001',
                'lat_range' => [-6.18, -6.13],
                'lng_range' => [106.70, 106.76],
                'city_name' => 'Jakarta Barat',
            ],
            [
                'province_id' => '32', // Jawa Barat
                'regency_id' => '3273', // Kota Bandung
                'district_id' => '3273060',
                'village_id' => '3273060001',
                'lat_range' => [-6.95, -6.88],
                'lng_range' => [107.57, 107.64],
                'city_name' => 'Bandung',
            ],
            [
                'province_id' => '32', // Jawa Barat
                'regency_id' => '3201', // Kab. Bogor
                'district_id' => '3201010',
                'village_id' => '3201010001',
                'lat_range' => [-6.62, -6.53],
                'lng_range' => [106.75, 106.85],
                'city_name' => 'Bogor',
            ],
            [
                'province_id' => '35', // Jawa Timur
                'regency_id' => '3578', // Kota Surabaya
                'district_id' => '3578060',
                'village_id' => '3578060001',
                'lat_range' => [-7.32, -7.23],
                'lng_range' => [112.70, 112.78],
                'city_name' => 'Surabaya',
            ],
            [
                'province_id' => '35', // Jawa Timur
                'regency_id' => '3573', // Kota Malang
                'district_id' => '3573010',
                'village_id' => '3573010001',
                'lat_range' => [-8.02, -7.94],
                'lng_range' => [112.60, 112.66],
                'city_name' => 'Malang',
            ],
            [
                'province_id' => '33', // Jawa Tengah
                'regency_id' => '3374', // Kota Semarang
                'district_id' => '3374010',
                'village_id' => '3374010001',
                'lat_range' => [-7.05, -6.95],
                'lng_range' => [110.38, 110.45],
                'city_name' => 'Semarang',
            ],
            [
                'province_id' => '33', // Jawa Tengah
                'regency_id' => '3372', // Kota Surakarta
                'district_id' => '3372010',
                'village_id' => '3372010001',
                'lat_range' => [-7.59, -7.53],
                'lng_range' => [110.79, 110.85],
                'city_name' => 'Surakarta',
            ],
            [
                'province_id' => '34', // DI Yogyakarta
                'regency_id' => '3471', // Kota Yogyakarta
                'district_id' => '3471010',
                'village_id' => '3471010001',
                'lat_range' => [-7.83, -7.77],
                'lng_range' => [110.34, 110.40],
                'city_name' => 'Yogyakarta',
            ],
            [
                'province_id' => '51', // Bali
                'regency_id' => '5171', // Kota Denpasar
                'district_id' => '5171010',
                'village_id' => '5171010001',
                'lat_range' => [-8.70, -8.62],
                'lng_range' => [115.18, 115.26],
                'city_name' => 'Denpasar',
            ],
            [
                'province_id' => '12', // Sumatera Utara
                'regency_id' => '1271', // Kota Medan
                'district_id' => '1271010',
                'village_id' => '1271010001',
                'lat_range' => [3.55, 3.65],
                'lng_range' => [98.63, 98.71],
                'city_name' => 'Medan',
            ],
            [
                'province_id' => '73', // Sulawesi Selatan
                'regency_id' => '7371', // Kota Makassar
                'district_id' => '7371010',
                'village_id' => '7371010001',
                'lat_range' => [-5.18, -5.10],
                'lng_range' => [119.40, 119.48],
                'city_name' => 'Makassar',
            ],
            [
                'province_id' => '11',
                'regency_id' => '1171', // Kota Banda Aceh
                'district_id' => '1171010',
                'village_id' => '1171010001',
                'lat_range' => [5.52, 5.57],
                'lng_range' => [95.30, 95.34],
                'city_name' => 'Banda Aceh',
            ],
            [
                'province_id' => '13',
                'regency_id' => '1371', // Kota Padang
                'district_id' => '1371010',
                'village_id' => '1371010001',
                'lat_range' => [-0.96, -0.91],
                'lng_range' => [100.34, 100.40],
                'city_name' => 'Padang',
            ],
            [
                'province_id' => '16',
                'regency_id' => '1671', // Kota Palembang
                'district_id' => '1671010',
                'village_id' => '1671010001',
                'lat_range' => [-3.02, -2.96],
                'lng_range' => [104.73, 104.79],
                'city_name' => 'Palembang',
            ],
            [
                'province_id' => '14',
                'regency_id' => '1471', // Kota Pekanbaru
                'district_id' => '1471010',
                'village_id' => '1471010001',
                'lat_range' => [0.47, 0.53],
                'lng_range' => [101.42, 101.47],
                'city_name' => 'Pekanbaru',
            ],
            [
                'province_id' => '18',
                'regency_id' => '1871', // Kota Bandar Lampung
                'district_id' => '1871010',
                'village_id' => '1871010001',
                'lat_range' => [-5.45, -5.39],
                'lng_range' => [105.23, 105.28],
                'city_name' => 'Bandar Lampung',
            ],
            [
                'province_id' => '61',
                'regency_id' => '6171', // Kota Pontianak
                'district_id' => '6171010',
                'village_id' => '6171010001',
                'lat_range' => [-0.06, -0.01],
                'lng_range' => [109.31, 109.36],
                'city_name' => 'Pontianak',
            ],
            [
                'province_id' => '63',
                'regency_id' => '6371', // Kota Banjarmasin
                'district_id' => '6371010',
                'village_id' => '6371010001',
                'lat_range' => [-3.35, -3.29],
                'lng_range' => [114.56, 114.61],
                'city_name' => 'Banjarmasin',
            ],
            [
                'province_id' => '64',
                'regency_id' => '6471', // Kota Balikpapan
                'district_id' => '6471010',
                'village_id' => '6471010001',
                'lat_range' => [-1.28, -1.23],
                'lng_range' => [116.82, 116.87],
                'city_name' => 'Balikpapan',
            ],
            [
                'province_id' => '64',
                'regency_id' => '6472', // Kota Samarinda
                'district_id' => '6472010',
                'village_id' => '6472010001',
                'lat_range' => [-0.52, -0.47],
                'lng_range' => [117.11, 117.17],
                'city_name' => 'Samarinda',
            ],
            [
                'province_id' => '71',
                'regency_id' => '7171', // Kota Manado
                'district_id' => '7171010',
                'village_id' => '7171010001',
                'lat_range' => [1.46, 1.51],
                'lng_range' => [124.81, 124.86],
                'city_name' => 'Manado',
            ],
            [
                'province_id' => '74',
                'regency_id' => '7471', // Kota Kendari
                'district_id' => '7471010',
                'village_id' => '7471010001',
                'lat_range' => [-4.00, -3.95],
                'lng_range' => [122.48, 122.53],
                'city_name' => 'Kendari',
            ],
            [
                'province_id' => '81',
                'regency_id' => '8171', // Kota Ambon
                'district_id' => '8171010',
                'village_id' => '8171010001',
                'lat_range' => [-3.72, -3.67],
                'lng_range' => [128.15, 128.20],
                'city_name' => 'Ambon',
            ],
            [
                'province_id' => '91',
                'regency_id' => '9171', // Kota Jayapura
                'district_id' => '9171010',
                'village_id' => '9171010001',
                'lat_range' => [-2.56, -2.51],
                'lng_range' => [140.67, 140.72],
                'city_name' => 'Jayapura',
            ],
            [
                'province_id' => '52',
                'regency_id' => '5271', // Kota Mataram
                'district_id' => '5271010',
                'village_id' => '5271010001',
                'lat_range' => [-8.61, -8.56],
                'lng_range' => [116.08, 116.13],
                'city_name' => 'Mataram',
            ],
            [
                'province_id' => '53',
                'regency_id' => '5371', // Kota Kupang
                'district_id' => '5371010',
                'village_id' => '5371010001',
                'lat_range' => [-10.19, -10.14],
                'lng_range' => [123.57, 123.62],
                'city_name' => 'Kupang',
            ],
            [
                'province_id' => '36',
                'regency_id' => '3671', // Kota Tangerang
                'district_id' => '3671010',
                'village_id' => '3671010001',
                'lat_range' => [-6.22, -6.17],
                'lng_range' => [106.60, 106.65],
                'city_name' => 'Tangerang',
            ],
            [
                'province_id' => '36',
                'regency_id' => '3673', // Kota Serang
                'district_id' => '3673010',
                'village_id' => '3673010001',
                'lat_range' => [-6.14, -6.09],
                'lng_range' => [106.13, 106.18],
                'city_name' => 'Serang',
            ],
            [
                'province_id' => '32',
                'regency_id' => '3275', // Kota Bekasi
                'district_id' => '3275010',
                'village_id' => '3275010001',
                'lat_range' => [-6.27, -6.22],
                'lng_range' => [106.96, 107.01],
                'city_name' => 'Bekasi',
            ],
            [
                'province_id' => '15',
                'regency_id' => '1571', // Kota Jambi
                'district_id' => '1571010',
                'village_id' => '1571010001',
                'lat_range' => [-1.63, -1.58],
                'lng_range' => [103.58, 103.63],
                'city_name' => 'Jambi',
            ],
            [
                'province_id' => '17',
                'regency_id' => '1771', // Kota Bengkulu
                'district_id' => '1771010',
                'village_id' => '1771010001',
                'lat_range' => [-3.82, -3.77],
                'lng_range' => [102.23, 102.28],
                'city_name' => 'Bengkulu',
            ],
            [
                'province_id' => '19',
                'regency_id' => '1971', // Kota Pangkal Pinang
                'district_id' => '1971010',
                'village_id' => '1971010001',
                'lat_range' => [-2.14, -2.09],
                'lng_range' => [106.08, 106.13],
                'city_name' => 'Pangkal Pinang',
            ],
            [
                'province_id' => '21',
                'regency_id' => '2171', // Kota Batam
                'district_id' => '2171010',
                'village_id' => '2171010001',
                'lat_range' => [1.10, 1.15],
                'lng_range' => [104.00, 104.05],
                'city_name' => 'Batam',
            ],
            [
                'province_id' => '62',
                'regency_id' => '6271', // Kota Palangkaraya
                'district_id' => '6271010',
                'village_id' => '6271010001',
                'lat_range' => [-2.23, -2.18],
                'lng_range' => [113.88, 113.93],
                'city_name' => 'Palangkaraya',
            ],
            [
                'province_id' => '65',
                'regency_id' => '6571', // Kota Tarakan
                'district_id' => '6571010',
                'village_id' => '6571010001',
                'lat_range' => [3.28, 3.33],
                'lng_range' => [117.56, 117.61],
                'city_name' => 'Tarakan',
            ],
            [
                'province_id' => '72',
                'regency_id' => '7271', // Kota Palu
                'district_id' => '7271010',
                'village_id' => '7271010001',
                'lat_range' => [-0.91, -0.86],
                'lng_range' => [119.84, 119.89],
                'city_name' => 'Palu',
            ],
            [
                'province_id' => '75',
                'regency_id' => '7571', // Kota Gorontalo
                'district_id' => '7571010',
                'village_id' => '7571010001',
                'lat_range' => [0.52, 0.57],
                'lng_range' => [123.03, 123.08],
                'city_name' => 'Gorontalo',
            ],
            [
                'province_id' => '76',
                'regency_id' => '7604', // Kab. Mamuju
                'district_id' => '7604010',
                'village_id' => '7604010001',
                'lat_range' => [-2.69, -2.64],
                'lng_range' => [118.86, 118.91],
                'city_name' => 'Mamuju',
            ],
            [
                'province_id' => '82',
                'regency_id' => '8271', // Kota Ternate
                'district_id' => '8271010',
                'village_id' => '8271010001',
                'lat_range' => [0.77, 0.82],
                'lng_range' => [127.35, 127.40],
                'city_name' => 'Ternate',
            ],
            [
                'province_id' => '92',
                'regency_id' => '9271', // Kota Sorong
                'district_id' => '9271010',
                'village_id' => '9271010001',
                'lat_range' => [-0.89, -0.84],
                'lng_range' => [131.23, 131.28],
                'city_name' => 'Sorong',
            ],
        ];

        $location = fake()->randomElement($locations);

        $lat = fake()->randomFloat(6, $location['lat_range'][0], $location['lat_range'][1]);
        $lng = fake()->randomFloat(6, $location['lng_range'][0], $location['lng_range'][1]);

        return [
            'nik' => fake()->unique()->numerify('################'),
            'full_name' => fake()->name(),
            'gender' => fake()->randomElement(['M', 'F']),
            'place_of_birth' => $location['city_name'],
            'date_of_birth' => fake()->dateTimeBetween('-60 years', '-17 years')->format('Y-m-d'),
            'phone_number' => fake()->numerify('08##########'),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->streetAddress().', '.$location['city_name'],
            'rt' => fake()->numerify('0##'),
            'rw' => fake()->numerify('0##'),
            'province_id' => $location['province_id'],
            'regency_id' => $location['regency_id'],
            'district_id' => $location['district_id'],
            'village_id' => $location['village_id'],
            'postal_code' => fake()->numerify('#####'),
            'latitude' => $lat,
            'longitude' => $lng,
            'profession' => fake()->jobTitle(),
            'photo' => null,
            'notes' => fake()->optional(0.3)->sentence(),
            'status' => fake()->randomElement(['active', 'active', 'active', 'active', 'inactive']),
            'created_at' => $createdAt = fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $createdAt,
        ];
    }

    /**
     * Indicate that the massa is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the massa is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }
}
