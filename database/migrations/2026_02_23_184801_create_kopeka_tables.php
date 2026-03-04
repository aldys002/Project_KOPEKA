<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // 1. Tabel Anggota
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            // UNIQUE DIHAPUS agar NIPP 'OUT'/'TOKO' bisa masuk berkali-kali
            $table->string('nipp', 50)->nullable(); 
            $table->string('nik', 50)->nullable();
            $table->string('users', 150); 
            $table->string('password');
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Tabel Simpanan
        Schema::create('simpanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->nullable()->constrained('anggota')->onDelete('cascade');
            $table->string('nipp_asal')->nullable(); 
            $table->integer('tahun');
            $table->decimal('pokok', 15, 2)->default(0);
            $table->decimal('wajib', 15, 2)->default(0);
            $table->decimal('sukarela', 15, 2)->default(0);
            $table->decimal('total_simpanan', 15, 2)->default(0);
            $table->timestamps();
        });

        // 3. Tabel Hutang
        Schema::create('hutang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->nullable()->constrained('anggota')->onDelete('cascade');
            $table->string('nipp_asal')->nullable(); 
            $table->integer('tahun');
            $table->decimal('saldo_hutang', 15, 2)->default(0);
            $table->timestamps();
        });

        // 4. Tabel Password Reset
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 5. Tabel Sessions
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