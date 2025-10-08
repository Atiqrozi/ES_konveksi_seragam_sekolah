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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pekerjaan_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status_kegiatan');
            $table->integer('jumlah_kegiatan');
            $table->text('catatan')->nullable();
            $table->timestamp('kegiatan_dibuat')->nullable();

            $table->timestamps();

            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaans')->onUpdate('CASCADE')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
