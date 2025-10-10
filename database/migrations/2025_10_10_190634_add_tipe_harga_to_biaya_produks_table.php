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
        Schema::table('biaya_produks', function (Blueprint $table) {
            // Menambahkan kolom untuk 4 tipe harga per ukuran
            $table->json('harga_per_ukuran')->nullable()->comment('Harga untuk semua ukuran dan tipe harga dalam format JSON');
            
            // Atau bisa menggunakan pendekatan terpisah untuk setiap ukuran
            $table->decimal('harga_s_1', 15, 2)->nullable()->comment('Harga ukuran S tipe 1');
            $table->decimal('harga_s_2', 15, 2)->nullable()->comment('Harga ukuran S tipe 2');
            $table->decimal('harga_s_3', 15, 2)->nullable()->comment('Harga ukuran S tipe 3');
            $table->decimal('harga_s_4', 15, 2)->nullable()->comment('Harga ukuran S tipe 4');
            
            $table->decimal('harga_m_1', 15, 2)->nullable()->comment('Harga ukuran M tipe 1');
            $table->decimal('harga_m_2', 15, 2)->nullable()->comment('Harga ukuran M tipe 2');
            $table->decimal('harga_m_3', 15, 2)->nullable()->comment('Harga ukuran M tipe 3');
            $table->decimal('harga_m_4', 15, 2)->nullable()->comment('Harga ukuran M tipe 4');
            
            $table->decimal('harga_l_1', 15, 2)->nullable()->comment('Harga ukuran L tipe 1');
            $table->decimal('harga_l_2', 15, 2)->nullable()->comment('Harga ukuran L tipe 2');
            $table->decimal('harga_l_3', 15, 2)->nullable()->comment('Harga ukuran L tipe 3');
            $table->decimal('harga_l_4', 15, 2)->nullable()->comment('Harga ukuran L tipe 4');
            
            $table->decimal('harga_xl_1', 15, 2)->nullable()->comment('Harga ukuran XL tipe 1');
            $table->decimal('harga_xl_2', 15, 2)->nullable()->comment('Harga ukuran XL tipe 2');
            $table->decimal('harga_xl_3', 15, 2)->nullable()->comment('Harga ukuran XL tipe 3');
            $table->decimal('harga_xl_4', 15, 2)->nullable()->comment('Harga ukuran XL tipe 4');
            
            $table->decimal('harga_xxl_1', 15, 2)->nullable()->comment('Harga ukuran XXL tipe 1');
            $table->decimal('harga_xxl_2', 15, 2)->nullable()->comment('Harga ukuran XXL tipe 2');
            $table->decimal('harga_xxl_3', 15, 2)->nullable()->comment('Harga ukuran XXL tipe 3');
            $table->decimal('harga_xxl_4', 15, 2)->nullable()->comment('Harga ukuran XXL tipe 4');
            
            $table->decimal('harga_jumbo_1', 15, 2)->nullable()->comment('Harga ukuran JUMBO tipe 1');
            $table->decimal('harga_jumbo_2', 15, 2)->nullable()->comment('Harga ukuran JUMBO tipe 2');
            $table->decimal('harga_jumbo_3', 15, 2)->nullable()->comment('Harga ukuran JUMBO tipe 3');
            $table->decimal('harga_jumbo_4', 15, 2)->nullable()->comment('Harga ukuran JUMBO tipe 4');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biaya_produks', function (Blueprint $table) {
            $table->dropColumn([
                'harga_per_ukuran',
                'harga_s_1', 'harga_s_2', 'harga_s_3', 'harga_s_4',
                'harga_m_1', 'harga_m_2', 'harga_m_3', 'harga_m_4',
                'harga_l_1', 'harga_l_2', 'harga_l_3', 'harga_l_4',
                'harga_xl_1', 'harga_xl_2', 'harga_xl_3', 'harga_xl_4',
                'harga_xxl_1', 'harga_xxl_2', 'harga_xxl_3', 'harga_xxl_4',
                'harga_jumbo_1', 'harga_jumbo_2', 'harga_jumbo_3', 'harga_jumbo_4'
            ]);
        });
    }
};
