<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * 1. Setting Primary Key ke NIPP
     * Karena NIPP bukan angka urut (auto-increment) dan berupa string/varchar
     */
    protected $primaryKey = 'nipp';
    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * 2. Daftar kolom yang boleh diisi (Mass Assignment)
     */
    protected $fillable = [
        'nipp',
        'nama_anggota', 
        'nik',
        'password',
        'role',
    ];

    /**
     * 3. Sembunyikan data sensitif saat data ditarik
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 4. Casts untuk keamanan Password
     * Ini biar Laravel tahu kolom password harus di-hash secara otomatis
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * 5. Relasi ke tabel Simpanan
     * Pakai hasMany karena satu anggota bisa punya banyak catatan simpanan
     */
    public function simpanan(): HasMany
    {
        // Parameter: (NamaModel, Foreign_Key_di_Simpanan, Local_Key_di_User)
        return $this->hasMany(Simpanan::class, 'nipp', 'nipp');
    }

    /**
     * 6. Relasi ke tabel Hutang
     * Pakai hasMany karena anggota mungkin punya beberapa jenis pinjaman
     */
    public function hutang(): HasMany
    {
        return $this->hasMany(Hutang::class, 'nipp', 'nipp');
    }
}