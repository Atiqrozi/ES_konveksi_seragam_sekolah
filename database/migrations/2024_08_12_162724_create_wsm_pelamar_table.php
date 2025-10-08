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
        Schema::create('wsm_pelamars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pelamar_id');
            $table->unsignedBigInteger('kriteria_id');
            $table->integer('skor');

            $table->timestamps();

            $table->foreign('pelamar_id')->references('id')->on('pelamars')->onUpdate('CASCADE')->onDelete('cascade');
            $table->foreign('kriteria_id')->references('id')->on('kriterias')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wsm_pelamars');
    }
};
