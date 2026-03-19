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
    Schema::table('transaksi_bulanan', function (Blueprint $table) {
        // Tambahkan kolom saldo_hutang setelah kolom sukarela
        $table->bigInteger('saldo_hutang')->default(0)->after('sukarela');
    });
}

public function down(): void
{
    Schema::table('transaksi_bulanan', function (Blueprint $table) {
        $table->dropColumn('saldo_hutang');
    });
}
};
