<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'Selamat Tahun Baru 2026!',
                'content' => 'Pihak manajemen mengucapkan Selamat Tahun Baru 2026 kepada seluruh karyawan. Semoga tahun ini membawa kesuksesan dan keberkahan bagi kita semua.',
                'excerpt' => 'Ucapan selamat tahun baru dari manajemen',
                'type' => 'announcement',
                'is_pinned' => true,
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 1,
            ],
            [
                'title' => 'Jadwal Cuti Bersama 2026',
                'content' => 'Berikut adalah jadwal cuti bersama yang telah ditetapkan untuk tahun 2026. Harap diperhatikan untuk perencanaan kerja dan cuti pribadi.',
                'excerpt' => 'Informasi jadwal cuti bersama tahun 2026',
                'type' => 'policy',
                'is_pinned' => false,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'created_by' => 1,
            ],
            [
                'title' => 'Pengumuman Kenaikan Gaji',
                'content' => 'Dengan bangga kami umumkan bahwa seluruh karyawan akan menerima penyesuaian gaji sebesar 5% mulai bulan depan sebagai apresiasi atas kinerja yang baik.',
                'excerpt' => 'Penyesuaian gaji 5% untuk seluruh karyawan',
                'type' => 'announcement',
                'is_pinned' => false,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'created_by' => 1,
            ],
            [
                'title' => 'Gathering Karyawan - Februari 2026',
                'content' => 'Acara gathering karyawan akan diadakan pada tanggal 15 Februari 2026 di Taman Mini Indonesia Indah. Seluruh karyawan beserta keluarga diundang untuk hadir.',
                'excerpt' => 'Family gathering 15 Februari 2026',
                'type' => 'event',
                'is_pinned' => false,
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'created_by' => 1,
            ],
            [
                'title' => 'Employee of the Month - Januari 2026',
                'content' => 'Selamat kepada Bapak Ahmad Fauzi sebagai Employee of the Month untuk bulan Januari 2026. Prestasinya dalam meningkatkan efisiensi operasional sangat luar biasa.',
                'excerpt' => 'Penghargaan untuk Ahmad Fauzi',
                'type' => 'achievement',
                'is_pinned' => false,
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'created_by' => 1,
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}
