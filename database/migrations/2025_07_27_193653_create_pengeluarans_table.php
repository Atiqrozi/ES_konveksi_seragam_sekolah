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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jenis_pengeluaran_id');
            $table->string('keterangan')->nullable();
            $table->bigInteger('jumlah');
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('jenis_pengeluaran_id')->references('id')->on('jenis_pengeluarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
