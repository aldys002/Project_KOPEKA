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

        // Ambil semua anggota dan kelompokkan berdasarkan NIPP/NIK sebagai kunci
        // Ini kunci rahasia supaya NIPP "Out" atau "Toko" yang banyak bisa dibagi rata
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

                // Ambil satu anggota dari antrian berdasarkan NIPP/Identitas CSV
                if (isset($poolSimpanan[$identityCsv]) && $poolSimpanan[$identityCsv]->count() > 0) {
                    // shift() mengambil satu item teratas dan menghapusnya dari antrian pool
                    $anggotaId = $poolSimpanan[$identityCsv]->shift()->id;
                }

                DB::table('simpanan')->insert([
                    'anggota_id'     => $anggotaId,
                    'nipp_asal'      => $identityCsv, 
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

                // Ambil satu anggota dari antrian pool hutang
                if (isset($poolHutang[$identityCsv]) && $poolHutang[$identityCsv]->count() > 0) {
                    $anggotaId = $poolHutang[$identityCsv]->shift()->id;
                }

                DB::table('hutang')->insert([
                    'anggota_id'    => $anggotaId,
                    'nipp_asal'     => $identityCsv, 
                    'tahun'         => $tahunAktif,
                    'saldo_hutang'  => $this->cleanNumber($rowH[1] ?? 0),
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }

        $this->command->info("Seeding Selesai! Data simpanan & hutang sekarang terbagi rata ke ID anggota yang unik.");
    }

    /**
     * Membersihkan string angka dari karakter non-numerik (titik, koma, spasi)
     */
    private function cleanNumber($value) {
        if (!$value) return 0;
        // Hapus karakter yang sering muncul di format rupiah
        $clean = str_replace(['.', ' ', ',', 'Rp'], '', $value);
        return (float) $clean;
    }
}