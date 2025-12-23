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
        Schema::create('stok_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->string('ukuran_produk');
            $table->integer('stok_tersedia')->default(0);
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi produk + ukuran
            $table->unique(['produk_id', 'ukuran_produk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_produk');
    }
};
