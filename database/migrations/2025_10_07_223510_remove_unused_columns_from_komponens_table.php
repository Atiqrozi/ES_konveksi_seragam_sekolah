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
        Schema::table('produk_komponens', function (Blueprint $table) {
            if (Schema::hasColumn('produk_komponens', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_komponens', function (Blueprint $table) {
            $table->text('keterangan')->nullable();
        });
    }
};
