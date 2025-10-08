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
        Schema::create('produk_komponens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->foreignId('komponen_id')->constrained('komponens')->onDelete('cascade');
            $table->decimal('quantity', 10, 3); // Jumlah komponen yang digunakan
            $table->timestamps();

            // Index untuk performa query
            $table->index(['produk_id']);
            $table->unique(['produk_id', 'komponen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_komponens');
    }
};