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
        Schema::create('pelamars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('email');
            $table->string('alamat');
            $table->string('no_telepon');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('pendidikan_terakhir');
            $table->unsignedBigInteger('posisi_id');
            $table->text('tentang_diri')->nullable();
            $table->text('pengalaman')->nullable();
            $table->string('foto');
            $table->string('cv');
            $table->string('status');

            $table->decimal('weighted_sum_model', 5, 2)->nullable();

            $table->dateTime('mulai_wawancara')->nullable();
            $table->dateTime('selesai_wawancara')->nullable();

            $table->timestamps();

            $table->foreign('posisi_id')->references('id')->on('posisi_lowongans')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelamars');
    }
};