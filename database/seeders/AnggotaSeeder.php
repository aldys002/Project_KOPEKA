<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AnggotaSeeder extends Seeder
{
    public function run()
    {
        $file = database_path('seeders/anggota.csv');

        if (!File::exists($file)) {
            $this->command->error("File anggota.csv tidak ditemukan di folder seeders!");
            return;
        }

        // Membaca file CSV
        $data = array_map('str_getcsv', file($file));

        foreach ($data as $row) {
            // Skip jika baris kosong
            if (empty($row[0]) || empty($row[1])) continue;

            User::updateOrCreate(
                ['nipp' => $row[1]], // Ambil NIPP dari kolom ke-2
                [
                    'nama_anggota' => $row[0], // Ambil Nama dari kolom ke-1
                    'password'     => Hash::make('kai123'),
                    'role'         => 'user',
                ]
            );
        }
        
        $this->command->info("Seeding selesai! Data anggota berhasil diimport.");
    }
}