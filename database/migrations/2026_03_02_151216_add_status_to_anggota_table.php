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
    Schema::table('anggota', function (Blueprint $table) {
        // Kita tambah kolom status setelah kolom role, defaultnya 'aktif'
        $table->string('status')->default('aktif')->after('role');
    });
}

public function down(): void
{
    Schema::table('anggota', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}
};
