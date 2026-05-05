<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id', 'name');

        $defaultCategoryId = Category::first()?->id;

        if (! $defaultCategoryId) {
            return;
        }

        $events = [
            [
                'category_id' => $categories['Rapat Koordinasi'] ?? $defaultCategoryId,
                'name' => 'Rapat Koordinasi Wilayah',
                'description' => 'Rapat koordinasi membahas persiapan pemilu tingkat wilayah.',
                'organizer' => 'DPD Jakarta Pusat',
                'target_participants' => 100,
                'start_date' => '2026-05-10',
                'start_time' => '09:00',
                'end_date' => '2026-05-10',
                'end_time' => '15:00',
                'location' => 'Hotel Indonesia, Jakarta',
                'status' => 'published',
            ],
            [
                'category_id' => $categories['Kampanye'] ?? $defaultCategoryId,
                'name' => 'Kampanye Akbar Terbuka',
                'description' => 'Kampanye akbar bersama calon legislatif daerah dan tokoh masyarakat.',
                'organizer' => 'DPW Jawa Barat',
                'target_participants' => 500,
                'start_date' => '2026-06-15',
                'start_time' => '13:00',
                'end_date' => '2026-06-15',
                'end_time' => '18:00',
                'location' => 'Stadion Siliwangi, Bandung',
                'status' => 'published',
            ],
            [
                'category_id' => $categories['Bakti Sosial'] ?? $defaultCategoryId,
                'name' => 'Pengobatan Gratis Warga',
                'description' => 'Kegiatan bakti sosial pengobatan dan pemeriksaan kesehatan gratis untuk warga kurang mampu.',
                'organizer' => 'DPC Surabaya',
                'target_participants' => 500,
                'start_date' => '2026-04-20',
                'start_time' => '08:00',
                'end_date' => '2026-04-20',
                'end_time' => '14:00',
                'location' => 'Balai RW 03, Sukomanunggal',
                'status' => 'completed',
            ],
            [
                'category_id' => $categories['Diskusi Publik'] ?? $defaultCategoryId,
                'name' => 'Diskusi Peran Pemuda di Era Digital',
                'description' => 'Forum diskusi mengundang mahasiswa dan aktivis kepemudaan untuk membahas peran pemuda dalam politik.',
                'organizer' => 'Sayap Pemuda Partai',
                'target_participants' => 200,
                'start_date' => '2026-07-01',
                'start_time' => '19:00',
                'end_date' => '2026-07-01',
                'end_time' => '22:00',
                'location' => 'Kafe Literasi, Yogyakarta',
                'status' => 'draft',
            ],
            [
                'category_id' => $categories['Pelatihan & Kaderisasi'] ?? $defaultCategoryId,
                'name' => 'Pelatihan Kader Dasar Tingkat I',
                'description' => 'Pendidikan wajib bagi seluruh kader baru yang bergabung di tingkat cabang.',
                'organizer' => 'Badan Pendidikan dan Pelatihan',
                'target_participants' => 150,
                'start_date' => '2026-08-10',
                'start_time' => '08:00',
                'end_date' => '2026-08-12',
                'end_time' => '16:00',
                'location' => 'Pusdiklat Partai, Bogor',
                'status' => 'published',
            ],
            [
                'category_id' => $categories['Deklarasi'] ?? $defaultCategoryId,
                'name' => 'Deklarasi Calon Walikota',
                'description' => 'Acara peresmian dukungan untuk pasangan calon walikota di pilkada mendatang.',
                'organizer' => 'DPD Kota Medan',
                'target_participants' => 200,
                'start_date' => '2026-05-05',
                'start_time' => '10:00',
                'end_date' => '2026-05-05',
                'end_time' => '13:00',
                'location' => 'Lapangan Merdeka, Medan',
                'status' => 'cancelled',
            ],
        ];

        foreach ($events as $event) {
            $createdAt = fake()->dateTimeBetween('-1 year', 'now');
            $event['created_at'] = $createdAt;
            $event['updated_at'] = $createdAt;
            Event::create($event);
        }
    }
}
