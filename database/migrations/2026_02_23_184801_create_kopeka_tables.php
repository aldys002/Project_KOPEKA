<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Tabel Master Anggota
        Schema::create('anggota', function (Blueprint $table) {
            $table->string('nipp', 20)->primary(); // NIPP jadi Primary Key
            $table->string('nik', 20);
            $table->string('nama_anggota', 150);
            $table->string('password')->default(bcrypt('kai123')); 
            $table->timestamps();
        });

        // Tabel Simpanan
        Schema::create('simpanan', function (Blueprint $table) {
            $table->id();
            $table->string('nipp', 20);
            $table->decimal('pokok', 15, 2)->default(0);
            $table->decimal('wajib', 15, 2)->default(0);
            $table->decimal('sukarela', 15, 2)->default(0);
            $table->decimal('total_simpanan', 15, 2)->default(0);
            $table->foreign('nipp')->references('nipp')->on('anggota')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel Hutang
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->string('nipp', 20);
            $table->decimal('saldo_hutang_2025', 15, 2)->default(0);
            $table->foreign('nipp')->references('nipp')->on('anggota')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('hutang');
        Schema::dropIfExists('simpanan');
        Schema::dropIfExists('anggota');
    }
};