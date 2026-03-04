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
        // 1. Bersihkan tabel lama biar gak double data
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

                $identityCsv = trim($row[0]); // Contoh: 171277
                
                /** * SOLUSI UNTUK RIZKY SUGIARTI:
                 * Cari di tabel anggota, apakah 171277 ada di kolom NIPP atau NIK?
                 */
                $anggota = DB::table('anggota')
                            ->where('nipp', $identityCsv)
                            ->orWhere('nik', $identityCsv)
                            ->first();

                DB::table('simpanan')->insert([
                    'anggota_id'     => $anggota ? $anggota->id : null,
                    'nipp_asal'      => $identityCsv, 
                    'nik_asal'       => $identityCsv, // Backup identitas ke jembatan NIK
                    'tahun'          => $tahunAktif,
                    'pokok'          => $this->cleanNumber($row[1] ?? 0),
                    'wajib'          => $this->cleanNumber($row[2] ?? 0),
                    'sukarela'       => $this->cleanNumber($row[3] ?? 0),
                    'total_simpanan' => $this->cleanNumber($row[4] ?? 0),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

        // --- PROSES DATA HUTANG ---
        $pathHutang = database_path('seeders/hutang1.csv');
        if (File::exists($pathHutang)) {
            $dataHutangCsv = array_map('str_getcsv', file($pathHutang));
            $this->command->info("Memproses data hutang...");

            foreach ($dataHutangCsv as $indexH => $rowH) {
                if (empty($rowH[0])) continue;

                $identityCsv = trim($rowH[0]);
                $nominal = $this->cleanNumber($rowH[1] ?? 0); 

                // Cari kecocokan di NIPP atau NIK
                $anggota = DB::table('anggota')
                            ->where('nipp', $identityCsv)
                            ->orWhere('nik', $identityCsv)
                            ->first();

                DB::table('hutang')->insert([
                    'anggota_id'    => $anggota ? $anggota->id : null,
                    'nipp_asal'     => $identityCsv, 
                    'nik_asal'      => $identityCsv, 
                    'tahun'         => $tahunAktif,
                    'saldo_hutang'  => $nominal,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        $this->command->info("Seeding Selesai! Data Rizky (171277) sekarang terhubung via kolom NIK.");
    }

    private function cleanNumber($value) {
        if (!$value) return 0;
        // Hapus titik, spasi, atau koma agar jadi angka murni decimal
        $clean = str_replace(['.', ' ', ','], '', $value);
        return (float) $clean;
    }
}