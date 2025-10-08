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
        Schema::table('komponens', function (Blueprint $table) {
            $table->dropColumn(['keterangan', 'satuan', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komponens', function (Blueprint $table) {
            $table->text('keterangan')->nullable();
            $table->string('satuan');
            $table->boolean('is_active')->default(true);
        });
    }
};
