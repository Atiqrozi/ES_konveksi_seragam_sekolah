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
		Schema::table('produk_komponens', function (Blueprint $table) {
			// tambahkan kolom ukuran (nullable untuk aman terhadap data lama)
			$table->string('ukuran', 50)->nullable()->after('komponen_id');

			// ubah unique constraint: sebelumnya unique(produk_id, komponen_id)
			// sekarang kita ingin unique(produk_id, komponen_id, ukuran)
			// drop unique index lama (menggunakan kolom) lalu buat yang baru
			try {
				$table->dropUnique(['produk_id', 'komponen_id']);
			} catch (\Throwable $e) {
				// jika index tidak ada, lanjutkan tanpa error (saat migrate di beberapa environment)
			}

			$table->unique(['produk_id', 'komponen_id', 'ukuran']);
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('produk_komponens', function (Blueprint $table) {
			// restore index ke kondisi semula
			try {
				$table->dropUnique(['produk_id', 'komponen_id', 'ukuran']);
			} catch (\Throwable $e) {
				// ignore
			}

			// restore unique awal jika belum ada
			try {
				$table->unique(['produk_id', 'komponen_id']);
			} catch (\Throwable $e) {
				// ignore
			}

			// drop kolom ukuran
			if (Schema::hasColumn('produk_komponens', 'ukuran')) {
				$table->dropColumn('ukuran');
			}
		});
	}
};

