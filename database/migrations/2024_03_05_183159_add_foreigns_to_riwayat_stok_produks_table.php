<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('riwayat_stok_produks', function (Blueprint $table) {
            $table
                ->foreign('id_produk')
                ->references('id')
                ->on('produks')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_stok_produks', function (Blueprint $table) {
            $table->dropForeign(['id_produk']);
        });
    }
};
