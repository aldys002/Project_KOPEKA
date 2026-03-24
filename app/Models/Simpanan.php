<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $fillable = [
        'anggota_id',
        'nipp',           // Tambahkan ini agar sinkron dengan migrasi
        'nik',            // Tambahkan ini agar sinkron dengan migrasi
        'tahun',
        'pokok',
        'wajib',
        'sukarela',
        'total_simpanan'
    ];

    /**
     * Relasi balik ke User (Anggota)
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(User::class, 'anggota_id', 'id');
    }
}