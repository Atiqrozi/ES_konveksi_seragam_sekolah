<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PosisiLowonganSeeder::class);
        $this->call(PermissionsSeeder::class); // Aktifkan dan jalankan sebelum UserSeeder
        $this->call(UserSeeder::class);
        $this->call(KriteriaSeeder::class);
        $this->call(KategoriSeeder::class); // Tambahkan sebelum ProdukSeeder
        $this->call(ProdukSeeder::class);
        $this->call(UkuranProdukSeeder::class);
        $this->call(RiwayatStokProdukSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(PekerjaanSeeder::class);
        $this->call(KegiatanSeeder::class);
        $this->call(PelamarSeeder::class);
        $this->call(ArtikelSeeder::class);
        $this->call(WaktuOpenLamaranSeeder::class);
    }
}
