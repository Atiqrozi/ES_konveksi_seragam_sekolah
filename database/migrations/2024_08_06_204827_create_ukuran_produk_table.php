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
        Schema::create('ukuran_produks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produk_id');
            $table->string('ukuran');
            $table->integer('stok');
            $table->integer('harga_produk_1');
            $table->integer('harga_produk_2');
            $table->integer('harga_produk_3');
            $table->integer('harga_produk_4');

            $table->timestamps();

            $table->foreign('produk_id')->references('id')->on('produks')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukuran_produks');
    }
};
