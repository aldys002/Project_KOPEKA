<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hutang extends Model
{
    protected $table = 'hutang';

    protected $fillable = [
        'anggota_id',
        'nipp',           // Tambahkan ini agar sinkron dengan migrasi
        'nik',            // Tambahkan ini agar sinkron dengan migrasi
        'tahun',
        'saldo_hutang'
    ];

    /**
     * Relasi balik ke User (Anggota)
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(User::class, 'anggota_id', 'id');
    }
}