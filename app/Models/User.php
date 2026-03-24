<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Menentukan tabel anggota sebagai sumber data auth
    protected $table = 'anggota'; 

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Kolom yang boleh diisi secara massal.
     * Pastikan 'status' ada di sini agar tersimpan di DB.
     */
    protected $fillable = [
        'nipp',
        'nik',
        'users', 
        'password',
        'role',
        'status', // Tambahkan ini agar tidak error saat create/update status
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed', // Laravel akan otomatis menghas password saat disimpan
    ];

    /**
     * Relasi HasOne (Data Tunggal)
     */
    public function simpanan(): HasOne
    {
        return $this->hasOne(Simpanan::class, 'anggota_id', 'id');
    }

    public function hutang(): HasOne
    {
        return $this->hasOne(Hutang::class, 'anggota_id', 'id');
    }

    /**
     * Relasi HasMany (Riwayat Tahunan)
     */
    public function simpanans(): HasMany
    {
        return $this->hasMany(Simpanan::class, 'anggota_id', 'id');
    }

    public function hutangs(): HasMany
    {
        return $this->hasMany(Hutang::class, 'anggota_id', 'id');
    }

    /**
     * Helper untuk mengambil data berdasarkan tahun tertentu
     */
    public function simpananTahun($tahun = 2026)
    {
        return $this->simpanans()->where('tahun', $tahun)->first();
    }

    public function hutangTahun($tahun = 2026)
    {
        return $this->hutangs()->where('tahun', $tahun)->first();
    }
}