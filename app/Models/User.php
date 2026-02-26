<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Tambahkan ini agar Laravel tahu Primary Key-nya NIPP (bukan ID)
    protected $primaryKey = 'nipp';
    public $incrementing = false;
    protected $keyType = 'string';

    // 2. Update fillable agar bisa menyimpan NIPP dan NIK dari Excel
    protected $fillable = [
    'nipp',
    'nama_anggota', 
    'nik',
    'password',
    'role',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 3. Tambahkan Relasi ke tabel Simpanan
    public function simpanan()
    {
        return $this->hasOne(Simpanan::class, 'nipp', 'nipp');
    }

    // 4. Tambahkan Relasi ke tabel Hutang
    public function hutang()
    {
        return $this->hasOne(Hutang::class, 'nipp', 'nipp');
    }
}