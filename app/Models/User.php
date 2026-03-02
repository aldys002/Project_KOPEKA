<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne; // Tambahkan ini

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'anggota'; 

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nipp',
        'users', 
        'nik',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Relasi HasOne untuk Tabel (Dashboard Admin)
     * Agar pemanggilan $row->simpanan di Blade tidak error
     */
    public function simpanan(): HasOne
    {
        // Kita ambil data simpanan (asumsi tahun terbaru atau data tunggal)
        return $this->hasOne(Simpanan::class, 'anggota_id', 'id');
    }

    public function hutang(): HasOne
    {
        return $this->hasOne(Hutang::class, 'anggota_id', 'id');
    }

    /**
     * Relasi HasMany (Untuk riwayat simpanan tiap tahun)
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
     * Helper untuk ambil data spesifik tahun
     */
    public function simpananTahun($tahun = 2025)
    {
        return $this->simpanans()->where('tahun', $tahun)->first();
    }

    public function hutangTahun($tahun = 2025)
    {
        return $this->hutangs()->where('tahun', $tahun)->first();
    }
}