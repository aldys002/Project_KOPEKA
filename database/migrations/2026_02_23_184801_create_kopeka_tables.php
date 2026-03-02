<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
    Schema::create('anggota', function (Blueprint $table) {
        $table->id(); // Kunci utama baru (Auto Increment)
        $table->string('nipp', 50)->nullable(); 
        $table->string('nik', 50)->nullable();
        $table->string('users', 150); 
        $table->string('password');
        $table->string('role')->default('user');
        $table->rememberToken();
        $table->timestamps();
    });

    Schema::create('simpanan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade');
        $table->integer('tahun'); // Untuk filter tahun nanti
        $table->decimal('pokok', 15, 2)->default(0);
        $table->decimal('wajib', 15, 2)->default(0);
        $table->decimal('sukarela', 15, 2)->default(0);
        $table->decimal('total_simpanan', 15, 2)->default(0);
        $table->timestamps();
    });

    Schema::create('hutang', function (Blueprint $table) {
        $table->id();
        $table->foreignId('anggota_id')->constrained('anggota')->onDelete('cascade');
        $table->integer('tahun');
        $table->decimal('saldo_hutang', 15, 2)->default(0);
        $table->timestamps();
    });

        // Tabel pendukung default Laravel
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down() {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('hutang');
        Schema::dropIfExists('simpanan');
        Schema::dropIfExists('anggota');
    }
};