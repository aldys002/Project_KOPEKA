<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable

    use HasFactory, Notifiable;

    // Nama tabel di database sesuai migration lo
    protected $table = 'anggota'; 

    // Primary key bukan 'id', tapi 'nipp'
    protected $primaryKey = 'nipp';

    // Karena NIPP bukan angka auto-increment (tapi string/manual)
    public $incrementing = false;
    protected $keyType = 'string';

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


    public function getAuthIdentifierName()
    {
        return 'nipp';
    }


    public function simpanan(): HasOne
    {
        return $this->hasOne(Simpanan::class, 'nipp', 'nipp');
    }

    public function hutang(): HasOne
    {
        return $this->hasOne(Hutang::class, 'nipp', 'nipp');


    public function simpanans(): HasMany
    {
        return $this->hasMany(Simpanan::class, 'nipp', 'nipp');
    }

    public function hutangs(): HasMany
    {
        return $this->hasMany(Hutang::class, 'nipp', 'nipp');

    }
}