<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'anggota'; 
    protected $primaryKey = 'nipp';
    public $incrementing = false;
    protected $keyType = 'string';

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
    }
}