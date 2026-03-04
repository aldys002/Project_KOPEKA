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
        // 1. Admin tetap wajib ada
        User::updateOrCreate(
            ['nipp' => 'admin'],
            [
                'users'    => 'Administrator Kopeka',
                'nik'      => '0000000000',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
            ]
        );

        $file = database_path('seeders/anggota.csv');
        if (!file_exists($file)) {
            $this->command->error("File anggota.csv tidak ditemukan!");
            return;
        }

        $data = array_map('str_getcsv', file($file));
        $passwordDefault = Hash::make('kai123');

        foreach ($data as $row) {
    if (empty($row[0]) || empty($row[1])) continue;

    $nama = trim($row[0]);
    $nipp = trim($row[1]);
    $nik  = isset($row[2]) ? trim($row[2]) : null;

    if (strtolower($nipp) == 'nipp') continue;

    // GANTI JADI INI: Paksa buat baris baru terus
    User::create([
        'nipp'     => $nipp,
        'nik'      => $nik,
        'users'    => $nama,
        'password' => null,
        'role'     => 'user',
    ]);
}
        
        $this->command->info("Seeding selesai!");
    }
}