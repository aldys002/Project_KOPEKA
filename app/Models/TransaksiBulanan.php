<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBulanan extends Model
{
    use HasFactory;

    // KUNCI UTAMA: Karena di migration kamu namanya 'transaksi_bulanan'
    protected $table = 'transaksi_bulanan'; 

    protected $fillable = [
        'anggota_id',
        'bulan',
        'tahun',
        'pokok',
        'wajib',
        'sukarela',
        'bayar_hutang'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }
}