<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Produk;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Http\UploadedFile;

class ProdukControllerTest extends TestCase
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
    public function test_produk_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/produks');
        $response->assertStatus(200);
        $response->assertViewIs('masterdata.produks.index');
    }

    /** @test */
    public function test_store_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/produks', [
            'nama_produk' => 'tes',
            'deskripsi_produk' => 'tes',
            'foto_sampul' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response->assertRedirect('/produks');
        $this->assertDatabaseHas('produks', [
            'nama_produk' => 'tes',
        ]);
    }

    /** @test */
    public function test_show_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'deskripsi_produk' => 'tes',
            'foto_sampul' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response = $this->get('/produks/' . $produk->id);
        $response->assertStatus(200);
        $response->assertViewHas('produk', $produk);
    }

    /** @test */
    public function test_update_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'deskripsi_produk' => 'tes',
            'foto_sampul' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response = $this->put('/produks/' . $produk->id, [
            'nama_produk' => 'tes updated',
            'deskripsi_produk' => $produk->deskripsi_produk,
            'foto_sampul' => $produk->foto_sampul,
        ]);

        $response->assertRedirect('/produks/' . $produk->id . '/edit');
        $this->assertDatabaseHas('produks', [
            'id' => $produk->id,
            'nama_produk' => 'tes updated',
        ]);
    }

    /** @test */
    public function test_destroy_produk()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $produk = Produk::create([
            'nama_produk' => 'tes',
            'deskripsi_produk' => 'tes',
            'foto_sampul' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response = $this->delete('/produks/' . $produk->id);
        $response->assertRedirect('/produks');

        $this->assertDatabaseMissing('produks', ['id' => $produk->id]);
    }
}
