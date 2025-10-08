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
        Schema::create('produks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_produk');
            $table->unsignedBigInteger('kategori_id');
            $table->text('deskripsi_produk')->nullable();
            $table->string('foto_sampul');
            $table->string('foto_lain_1')->nullable();
            $table->string('foto_lain_2')->nullable();
            $table->string('foto_lain_3')->nullable();
            $table->string('video')->nullable();

            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategoris')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
