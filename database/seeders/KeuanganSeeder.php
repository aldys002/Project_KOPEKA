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
        // 1. Bersihkan tabel lama agar tidak terjadi penumpukan data saat re-seed
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('simpanan')->truncate();
        DB::table('hutang')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $tahunAktif = 2025;

        // Ambil semua anggota dan kelompokkan berdasarkan NIPP sebagai kunci
        $poolSimpanan = User::all()->groupBy('nipp');
        $poolHutang = User::all()->groupBy('nipp');

        // --- PROSES DATA SIMPANAN ---
        $pathSimp = database_path('seeders/simpanan1.csv');
        if (File::exists($pathSimp)) {
            $dataSimp = array_map('str_getcsv', file($pathSimp));
            $this->command->info("Memproses data simpanan...");

            foreach ($dataSimp as $row) {
                if (empty($row[0])) continue;

                $identityCsv = trim($row[0]);
                $anggotaId = null;
                $nikAsal = null;

                if (isset($poolSimpanan[$identityCsv]) && $poolSimpanan[$identityCsv]->count() > 0) {
                    $anggota = $poolSimpanan[$identityCsv]->shift();
                    $anggotaId = $anggota->id;
                    $nikAsal = $anggota->nik; 
                }

                DB::table('simpanan')->insert([
                    'anggota_id'     => $anggotaId,
                    'nipp'           => $identityCsv, // FIXED
                    'nik'            => $nikAsal,    // FIXED
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

            foreach ($dataHutangCsv as $rowH) {
                if (empty($rowH[0])) continue;

                $identityCsv = trim($rowH[0]);
                $anggotaId = null;
                $nikAsal = null;

                if (isset($poolHutang[$identityCsv]) && $poolHutang[$identityCsv]->count() > 0) {
                    $anggota = $poolHutang[$identityCsv]->shift();
                    $anggotaId = $anggota->id;
                    $nikAsal = $anggota->nik;
                }

                DB::table('hutang')->insert([
                    'anggota_id'    => $anggotaId,
                    'nipp'          => $identityCsv, // FIXED: Hilangkan '_asal'
                    'nik'           => $nikAsal,    // FIXED: Hilangkan '_asal'
                    'tahun'         => $tahunAktif,
                    'saldo_hutang'  => $this->cleanNumber($rowH[1] ?? 0),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        $this->command->info("Seeding Selesai! Data Simpanan & Hutang sekarang sinkron.");
    }

    private function cleanNumber($value) {
        if (!$value) return 0;
        $clean = str_replace(['.', ' ', ',', 'Rp'], '', $value);
        return (float) $clean;
    }
}