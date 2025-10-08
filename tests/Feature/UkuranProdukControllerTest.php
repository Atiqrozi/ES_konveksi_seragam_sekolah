<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produk;
use App\Models\UkuranProduk;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Http\UploadedFile;

class UkuranProdukControllerTest extends TestCase
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
    public function test_ukuran_produk_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/ukuran_produk');
        $response->assertStatus(200);
        $response->assertViewIs('masterdata.ukuran_produk.index');
    }

    /** @test */
    public function test_store_ukuran_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'deskripsi_produk' => 'tes',
            'foto_sampul' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response = $this->post('/ukuran_produk', [
            'produk_id' => $produk->id,
            'ukuran' => 'XL',
            'stok' => 100,
            'harga_produk_1' => 1000,
            'harga_produk_2' => 2000,
            'harga_produk_3' => 3000,
            'harga_produk_4' => 4000,
        ]);

        $response->assertRedirect('/ukuran_produk');
        $this->assertDatabaseHas('ukuran_produks', [
            'produk_id' => $produk->id,
        ]);
    }

    /** @test */
    public function test_show_ukuran_produk()
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

        $response = $this->get('/ukuran_produk/' . $ukuran_produk->id);
        $response->assertStatus(200);
        $response->assertViewHas('ukuran_produk', $ukuran_produk);
    }

    /** @test */
    public function test_update_ukuran_produk()
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

        $response = $this->put('/ukuran_produk/' . $ukuran_produk->id, [
            'produk_id' => $ukuran_produk->produk_id,
            'ukuran' => 'XXL',
            'stok' => $ukuran_produk->stok,
            'harga_produk_1' => $ukuran_produk->harga_produk_1,
            'harga_produk_2' => $ukuran_produk->harga_produk_2,
            'harga_produk_3' => $ukuran_produk->harga_produk_3,
            'harga_produk_4' => $ukuran_produk->harga_produk_4,
        ]);

        $response->assertRedirect('/ukuran_produk/' . $ukuran_produk->id . '/edit');
        $this->assertDatabaseHas('ukuran_produks', [
            'id' => $ukuran_produk->id,
            'ukuran' => 'XXL',
        ]);
    }

    /** @test */
    public function test_destroy_ukuran_produk()
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

        $response = $this->delete('/ukuran_produk/' . $ukuran_produk->id);
        $response->assertRedirect('/ukuran_produk');

        $this->assertDatabaseMissing('ukuran_produks', ['id' => $ukuran_produk->id]);
    }
}
