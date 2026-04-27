<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kampanye',
                'description' => 'Kegiatan kampanye politik dan sosialisasi program partai.',
            ],
            [
                'name' => 'Rapat Paripurna',
                'description' => 'Rapat besar yang dihadiri oleh seluruh anggota pengurus inti.',
            ],
            [
                'name' => 'Rapat Koordinasi',
                'description' => 'Rapat rutin untuk koordinasi antar divisi atau cabang.',
            ],
            [
                'name' => 'Bakti Sosial',
                'description' => 'Kegiatan sosial kemasyarakatan untuk membantu warga.',
            ],
            [
                'name' => 'Pelatihan & Kaderisasi',
                'description' => 'Program pendidikan dan pelatihan untuk kader partai.',
            ],
            [
                'name' => 'Deklarasi',
                'description' => 'Acara pernyataan sikap, dukungan, atau pencalonan resmi.',
            ],
            [
                'name' => 'Diskusi Publik',
                'description' => 'Forum diskusi terbuka mengenai isu-isu politik dan sosial.',
            ],
            [
                'name' => 'Musyawarah',
                'description' => 'Musyawarah tingkat nasional, daerah, maupun cabang.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => Str::slug($category['name']),
                    'description' => $category['description'],
                ]
            );
        }
    }
}
