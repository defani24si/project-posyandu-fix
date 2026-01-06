<?php

namespace Database\Seeders;

use App\Models\JadwalPosyandu;
use App\Models\Posyandu;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class JadwalPosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua posyandu
        $posyandus = Posyandu::all();
        
        if ($posyandus->count() == 0) {
            $this->command->error('Tidak ada data posyandu. Jalankan PosyanduSeeder terlebih dahulu.');
            return;
        }

        $temas = [
            'Imunisasi Balita',
            'Pemeriksaan Kesehatan Ibu Hamil',
            'Penimbangan Balita',
            'Penyuluhan Gizi',
            'Pemeriksaan Kesehatan Lansia',
            'Imunisasi Campak',
            'Konsultasi KB',
            'Pemeriksaan Tumbuh Kembang Anak',
            'Penyuluhan Kesehatan Reproduksi',
            'Pemeriksaan Kesehatan Umum',
        ];

        $keterangans = [
            'Kegiatan rutin bulanan untuk pemeriksaan kesehatan balita',
            'Pemeriksaan kesehatan ibu hamil dan konsultasi dengan bidan',
            'Penimbangan dan pengukuran tinggi badan balita',
            'Edukasi tentang gizi seimbang untuk keluarga',
            'Pemeriksaan tekanan darah dan kesehatan lansia',
            'Program imunisasi untuk mencegah penyakit campak',
            'Konsultasi dan pelayanan keluarga berencana',
            'Monitoring pertumbuhan dan perkembangan anak',
            'Edukasi kesehatan reproduksi untuk remaja dan dewasa',
            'Pemeriksaan kesehatan umum untuk seluruh keluarga',
        ];

        $jadwals = [];
        
        // Buat jadwal untuk 3 bulan ke depan
        for ($month = 0; $month < 3; $month++) {
            foreach ($posyandus->take(10) as $index => $posyandu) {
                $tanggal = Carbon::now()->addMonths($month)->addDays(($index + 1) * 2);
                
                $jadwals[] = [
                    'posyandu_id' => $posyandu->posyandu_id,
                    'tanggal' => $tanggal->format('Y-m-d'),
                    'tema' => $temas[$index % count($temas)],
                    'keterangan' => $keterangans[$index % count($keterangans)],
                ];
            }
        }

        foreach ($jadwals as $jadwal) {
            // Cek apakah jadwal sudah ada
            $existing = JadwalPosyandu::where('posyandu_id', $jadwal['posyandu_id'])
                                    ->where('tanggal', $jadwal['tanggal'])
                                    ->first();
            
            if (!$existing) {
                JadwalPosyandu::create($jadwal);
                $posyandu = Posyandu::find($jadwal['posyandu_id']);
                $this->command->info('Jadwal ' . $posyandu->nama . ' (' . $jadwal['tanggal'] . ') berhasil dibuat!');
            }
        }
    }
}
