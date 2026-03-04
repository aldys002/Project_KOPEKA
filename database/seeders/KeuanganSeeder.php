<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;

class KeuanganSeeder extends Seeder
{
    public function run()
    {
        // 1. Bersihkan tabel lama biar gak double
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('simpanan')->truncate();
        DB::table('hutang')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $tahunAktif = 2025;

        // --- PROSES DATA SIMPANAN ---
        $pathSimp = database_path('seeders/simpanan1.csv');
        if (File::exists($pathSimp)) {
            $dataSimp = array_map('str_getcsv', file($pathSimp));
            $this->command->info("Memproses data simpanan...");

            foreach ($dataSimp as $index => $row) {
                if (empty($row[0])) continue; // Skip baris kosong

                $nippCsv = trim($row[0]);
                
                // Cari apakah usernya SUDAH register?
                $anggota = User::where('nipp', $nippCsv)->first();

                DB::table('simpanan')->insert([
                    'anggota_id'     => $anggota ? $anggota->id : null, // Kalau belum ada, isi NULL
                    'nipp_asal'      => $nippCsv, // KUNCI UTAMA buat register nanti
                    'tahun'          => $tahunAktif,
                    'pokok'          => $this->cleanNumber($row[1] ?? 0),
                    'wajib'          => $this->cleanNumber($row[2] ?? 0),
                    'sukarela'       => $this->cleanNumber($row[3] ?? 0),
                    'total_simpanan' => $this->cleanNumber($row[4] ?? 0),
                    'created_at'     => now(),
                ]);
            }
        }

        // --- PROSES DATA HUTANG ---
    $pathHutang = database_path('seeders/hutang1.csv');
    if (File::exists($pathHutang)) {
        $dataHutangCsv = array_map('str_getcsv', file($pathHutang));
        $this->command->info("Memproses data hutang sesuai dokumen...");

        foreach ($dataHutangCsv as $indexH => $rowH) {
            if (empty($rowH[0])) continue;

            $nippCsv = trim($rowH[0]);
            // Ambil nominal mentah dari kolom ke-2 (index 1) dan bersihkan formatnya
            $nominal = $this->cleanNumber($rowH[1] ?? 0); 

            // Cari apakah usernya SUDAH register?
            $anggota = DB::table('anggota')->where('nipp', $nippCsv)->first();

            DB::table('hutang')->insert([
                'anggota_id'    => $anggota ? $anggota->id : null,
                'nipp_asal'     => $nippCsv, 
                'tahun'         => $tahunAktif,
                'saldo_hutang'  => $nominal, // DISINI: Langsung masukin sesuai CSV
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }

        $this->command->info("Seeding Keuangan Selesai! Data gantung tersimpan via nipp_asal.");
    }

    private function cleanNumber($value) {
        if (!$value) return 0;
        // Hapus titik/spasi agar jadi angka murni
        $clean = str_replace(['.', ' ', ','], '', $value);
        return (float) $clean;
    }
}