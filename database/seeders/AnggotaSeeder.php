<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // --- TAMBAHKAN ADMIN DI SINI ---
    \App\Models\User::updateOrCreate(
        ['nipp' => 'admin'], // Cari berdasarkan NIPP admin
        [
            'users'    => 'Administrator Kopeka',
            'nipp'     => 'admin',
            'nik'      => '0000000000',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'), // Password admin
            'role'     => 'admin',
        ]
    );
        $file = database_path('seeders/anggota.csv');
        $data = array_map('str_getcsv', file($file));
        
        // Buat hash sekali saja agar proses cepat
        $passwordDefault = Hash::make('kai123');

        $this->command->info("Sedang memasukkan 457 anggota...");

        foreach ($data as $row) {
            // 1. Lewati jika baris kosong
            if (empty($row[0]) || empty($row[1])) {
                continue;
            }

            // Bersihkan spasi
            $nama = trim($row[0]);
            $nipp = trim($row[1]);

            // 2. Lewati jika baris ini adalah header (tulisan "nama" atau "nipp")
            if (strtolower($nipp) == 'nipp' || strtolower($nama) == 'nama') {
                continue;
            }

            User::create([
                'users'    => $nama,
                'nipp'     => $nipp,
                'nik'      => isset($row[2]) ? trim($row[2]) : null,
                'password' => $passwordDefault,
                'role'     => 'user',
            ]);
        }

        $this->command->info("Seeding selesai! Data anggota berhasil diimport.");
    }
}