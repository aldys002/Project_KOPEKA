<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_bulanan', function (Blueprint $table) {
    $table->id();
    $table->foreignId('anggota_id')->constrained('anggota');
    $table->integer('bulan'); // 1 sampai 12
    $table->integer('tahun');
    $table->decimal('pokok', 15, 2)->default(0);
    $table->decimal('wajib', 15, 2)->default(0);
    $table->decimal('sukarela', 15, 2)->default(0);
    $table->decimal('bayar_hutang', 15, 2)->default(0); // Buat cicilan
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_bulanan');
    }
};
