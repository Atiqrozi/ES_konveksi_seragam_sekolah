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
            $table->decimal('harga_per_unit', 15, 2)->after('quantity')->comment('Harga per unit komponen saat ditambahkan');
            $table->decimal('total_harga', 15, 2)->after('harga_per_unit')->comment('Total harga komponen (quantity x harga_per_unit)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_komponens', function (Blueprint $table) {
            $table->dropColumn(['harga_per_unit', 'total_harga']);
        });
    }
};
