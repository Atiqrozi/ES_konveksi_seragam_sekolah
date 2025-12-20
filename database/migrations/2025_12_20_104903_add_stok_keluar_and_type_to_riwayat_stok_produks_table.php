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
        Schema::table('riwayat_stok_produks', function (Blueprint $table) {
            $table->integer('stok_keluar')->default(0)->after('stok_masuk');
            $table->enum('tipe_transaksi', ['masuk', 'keluar'])->default('masuk')->after('stok_keluar');
            $table->unsignedBigInteger('user_id')->nullable()->after('tipe_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_stok_produks', function (Blueprint $table) {
            $table->dropColumn(['stok_keluar', 'tipe_transaksi', 'user_id']);
        });
    }
};
