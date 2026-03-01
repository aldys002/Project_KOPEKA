<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    protected $table = 'hutang';
    protected $fillable = ['nipp', 'saldo_hutang_2025'];

    public function user()
    {
        return $this->belongsTo(User::class, 'nipp', 'nipp');
    }
}