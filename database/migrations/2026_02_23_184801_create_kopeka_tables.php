<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Hapus tabel lama jika ada
        Schema::dropIfExists('hutang');
        Schema::dropIfExists('simpanan');
        Schema::dropIfExists('anggota');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

        // 1. Tabel Anggota
        Schema::create('anggota', function (Blueprint $table) {
            $table->string('nipp', 20)->primary(); 
            $table->string('nik', 20)->nullable();
            $table->string('users', 150); 
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Tabel Simpanan
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

        // 3. Tabel Hutang
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->string('nipp', 20);
            $table->decimal('saldo_hutang_2025', 15, 2)->default(0);
            $table->foreign('nipp')->references('nipp')->on('anggota')->onDelete('cascade');
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