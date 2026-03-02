<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hutang extends Model
{
    protected $table = 'hutang';

    protected $fillable = [
        'anggota_id',
        'tahun',
        'saldo_hutang'
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(User::class, 'anggota_id', 'id');
    }
}