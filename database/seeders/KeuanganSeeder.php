<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Simpanan;
use App\Models\Hutang;

class KeuanganSeeder extends Seeder
{
    public function run()
    {
        // 1. Bersihkan tabel lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Simpanan::truncate();
        Hutang::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $tahunAktif = 2025;
        $semuaAnggota = User::where('role', 'user')->orderBy('id', 'asc')->get();

        // --- PROSES DATA SIMPANAN ---
        $pathSimp = database_path('seeders/simpanan1.csv');
        if (File::exists($pathSimp)) {
            $dataSimp = array_map('str_getcsv', file($pathSimp));
            $this->command->info("Memproses 457 data simpanan...");

            foreach ($semuaAnggota as $index => $anggota) {
                $row = $dataSimp[$index] ?? null; 
                if ($row) {
                    Simpanan::create([
                        'anggota_id'     => $anggota->id,
                        'tahun'          => $tahunAktif,
                        'pokok'          => $this->cleanNumber($row[1] ?? 0),
                        'wajib'          => $this->cleanNumber($row[2] ?? 0),
                        'sukarela'       => $this->cleanNumber($row[3] ?? 0),
                        'total_simpanan' => $this->cleanNumber($row[4] ?? 0),
                    ]);
                }
            }
        }

        // --- PROSES DATA HUTANG ---
        $pathHutang = database_path('seeders/hutang1.csv');
        if (File::exists($pathHutang)) {
            $dataHutangCsv = array_map('str_getcsv', file($pathHutang));
            $this->command->info("Memproses data hutang...");

            foreach ($dataHutangCsv as $indexH => $rowH) {
    if (empty($rowH[0])) continue;

    $nippCsv = trim($rowH[0]);
    $nominal = $this->cleanNumber($rowH[1] ?? 0);

    // 1. Coba cari pakai NIPP dulu (Standard)
    $anggota = User::where('nipp', $nippCsv)->first();

    // 2. Kalau Gagal, coba pakai LIKE (Siapa tahu ada spasi)
    if (!$anggota) {
        $anggota = User::where('nipp', 'LIKE', '%' . $nippCsv . '%')->first();
    }

    // 3. Kalau MASIH Gagal khusus buat 41377, kita cari berdasarkan urutan ID
    // Baris 25 di CSV biasanya merujuk ke ID 25 atau ID 24 di database
    if (!$anggota && $nippCsv == '41377') {
        $anggota = User::find($indexH); // Coba tembak langsung pakai ID urutan
    }

    if ($anggota) {
        Hutang::create([
            'anggota_id'    => $anggota->id,
            'tahun'         => $tahunAktif,
            'saldo_hutang'  => $nominal
        ]);
    } else {
        // Log terakhir: Kita tampilkan apa sih isi database baris ke 25?
        $cekDB = User::skip(23)->take(3)->get(['id', 'users', 'nipp']);
        $this->command->warn("Data di DB sekitar baris 25:");
        foreach($cekDB as $d) {
            $this->command->line("- ID: {$d->id}, Nama: {$d->users}, NIPP: {$d->nipp}");
        }
        $this->command->error("NIPP '$nippCsv' (Baris " . ($indexH+1) . ") BENERAN GAADA!");
    }

            }
        }

        $this->command->info("Seeding Keuangan Selesai!");
    } // <--- TUTUP FUNGSI RUN

    private function cleanNumber($value) {
        if (!$value) return 0;
        return (float) str_replace(['.', ' '], '', $value);
    }

    private function countDuplicate($data, $currentIndex, $nipp) {
        $count = 0;
        for ($i = 0; $i < $currentIndex; $i++) {
            if (isset($data[$i][0]) && trim($data[$i][0]) == $nipp) {
                $count++;
            }
        }
        return $count;
    }
} // <--- TUTUP CLASS