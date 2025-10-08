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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->string('invoice');
            $table->integer('sub_total')->nullable();
            $table->integer('tagihan_sebelumnya')->nullable();
            $table->integer('tagihan_total')->nullable();
            $table->integer('jumlah_bayar')->nullable();
            $table->integer('tagihan_sisa')->nullable();

            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
