<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class KeuanganSeeder extends Seeder
{
    public function run()
    {
        // 1. Bersihkan tabel biar nggak double data (Matikan FK check biar lancar)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('simpanan')->truncate();
        DB::table('hutang')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- BAGIAN 1: IMPORT SIMPANAN ---
        $pathSimp = database_path('seeders/simpanan1.csv');
        if (File::exists($pathSimp)) {
            $file = fopen($pathSimp, 'r');
            $successSimp = 0;
            $this->command->info("Memproses data simpanan...");

            while (($row = fgetcsv($file, 2000, ",")) !== FALSE) {
                $nipp = trim($row[0] ?? '');
                if (!empty($nipp) && DB::table('anggota')->where('nipp', $nipp)->exists()) {
                    DB::table('simpanan')->insert([
                        'nipp'           => $nipp,
                        'pokok'          => (float)str_replace(['.', ' '], '', $row[1] ?? 0),
                        'wajib'          => (float)str_replace(['.', ' '], '', $row[2] ?? 0),
                        'sukarela'       => (float)str_replace(['.', ' '], '', $row[3] ?? 0),
                        'total_simpanan' => (float)str_replace(['.', ' '], '', $row[4] ?? 0),
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                    $successSimp++;
                }
            }
            fclose($file);
            $this->command->info("Simpanan: $successSimp data berhasil.");
        }

        // --- BAGIAN 2: IMPORT HUTANG ---
        $pathHutang = database_path('seeders/hutang1.csv'); // Pastikan file ini ada di folder seeder!
        if (File::exists($pathHutang)) {
            $file = fopen($pathHutang, 'r');
            $successHutang = 0;
            $this->command->info("Memproses data hutang...");

            while (($row = fgetcsv($file, 2000, ",")) !== FALSE) {
                $nipp = trim($row[0] ?? '');
                if (!empty($nipp) && DB::table('anggota')->where('nipp', $nipp)->exists()) {
                    DB::table('hutang')->insert([
                        'nipp'               => $nipp,
                        // row[1] adalah nominal saldo hutang sesuai struktur yang kita bahas tadi
                        'saldo_hutang_2025'  => (float)str_replace(['.', ' '], '', $row[1] ?? 0),
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ]);
                    $successHutang++;
                }
            }
            fclose($file);
            $this->command->info("Hutang: $successHutang data berhasil.");
        } else {
            $this->command->warn("File hutang1.csv tidak ditemukan, skip import hutang.");
        }
    }
}