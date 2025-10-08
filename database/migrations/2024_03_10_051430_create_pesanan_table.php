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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('produk_id');
            $table->string('ukuran');
            $table->integer('jumlah_pesanan')->nullable();
            $table->integer('harga')->nullable();

            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('CASCADE')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produks')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
