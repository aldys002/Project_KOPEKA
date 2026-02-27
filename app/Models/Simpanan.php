<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanan';
    protected $fillable = ['nipp', 'pokok', 'wajib', 'sukarela', 'total_simpanan'];

    protected static function booted()
    {
        static::saving(function ($simpanan) {
            $simpanan->total_simpanan = $simpanan->pokok + $simpanan->wajib + $simpanan->sukarela;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nipp', 'nipp');
    }
}