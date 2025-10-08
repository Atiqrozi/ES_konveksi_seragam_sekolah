<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produk;
use App\Models\RiwayatStokProduk;
use App\Models\UkuranProduk;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Http\UploadedFile;

class StokMasukControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->seed(PermissionsSeeder::class);

        // Membuat pengguna untuk pengujian
        $this->user = User::create([
            'nama' => 'test',
            'alamat' => 'Indonesia',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);
    }

    /** @test */
    public function test_stok_masuk_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/riwayat_stok_produk');
        $response->assertStatus(200);
        $response->assertViewIs('transaksi.riwayat_stok_produk.index');
    }

    /** @test */
    public function test_store_stok_masuk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'deskripsi_produk' => 'tes',
            'foto_sampul' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $ukuran_produk = UkuranProduk::create([
            'produk_id' => $produk->id,
            'ukuran' => 'XL',
            'stok' => 100,
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
        ]);

        $response = $this->post('/riwayat_stok_produk', [
            'id_produk' => $produk->id,
            'ukuran_produk' => 'XL',
            'stok_masuk' => '10',
            'catatan' => 'test',
        ]);

        $response->assertRedirect('/riwayat_stok_produk');
        $this->assertDatabaseHas('riwayat_stok_produks', [
            'id_produk' => $produk->id,
        ]);
    }

    /** @test */
    public function test_show_stok_masuk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'deskripsi_produk' => 'tes',
            'foto_sampul' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $stok_masuk = RiwayatStokProduk::create([
            'id_produk' => $produk->id,
            'ukuran_produk' => 'XL',
            'stok_masuk' => '10',
            'catatan' => 'test',
        ]);

        $response = $this->get('/riwayat_stok_produk/' . $stok_masuk->id);
        $response->assertStatus(200);
        $response->assertViewHas('riwayat_stok_produk', $stok_masuk);
    }
}
