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
        Schema::create('penarikan_gajis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pegawai_id');
            $table->integer('gaji_yang_diajukan');
            $table->string('status');
            $table->timestamp('mulai_tanggal')->nullable();
            $table->timestamp('akhir_tanggal')->nullable();
            $table->timestamp('gaji_diberikan')->nullable();

            $table->timestamps();

            $table->foreign('pegawai_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan_gajis');
    }
};
