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
        Schema::create('biaya_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->decimal('total_biaya_komponen', 15, 2)->default(0)->comment('Total biaya dari semua komponen');
            $table->text('keterangan')->nullable()->comment('Keterangan tambahan untuk biaya produk');
            $table->timestamps();
            
            $table->unique('produk_id', 'unique_produk_biaya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya_produks');
    }
};
