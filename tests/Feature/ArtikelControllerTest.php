<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Artikel;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Http\UploadedFile;

class ArtikelControllerTest extends TestCase
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
    public function test_artikel_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/artikels');
        $response->assertStatus(200);
        $response->assertViewIs('masterdata.artikel.index');
    }

    /** @test */
    public function test_store_artikel()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/artikels', [
            'penulis' => $this->user->id,
            'judul' => 'tes',
            'konten' => 'tes',
            'slug' => 'tes',
            'cover' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response->assertRedirect('/artikels');
        $this->assertDatabaseHas('artikels', [
            'judul' => 'tes',
        ]);
    }

    /** @test */
    public function test_show_artikel()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $artikel = Artikel::create([
            'penulis' => $this->user->id,
            'judul' => 'tes',
            'konten' => 'tes',
            'slug' => 'tes',
            'cover' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response = $this->get('/artikels/' . $artikel->slug);
        $response->assertStatus(200);
        $response->assertViewHas('artikel', $artikel);
    }

    /** @test */
    public function test_update_artikel()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $artikel = Artikel::create([
            'penulis' => $this->user->id,
            'judul' => 'tes',
            'konten' => 'tes',
            'slug' => 'tes',
            'cover' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response = $this->put('/artikels/' . $artikel->slug, [
            'penulis' => $artikel->penulis,
            'judul' => 'tes updated',
            'konten' => $artikel->konten,
            'slug' => $artikel->slug,
            'cover' => $artikel->cover,
        ]);

        $response->assertRedirect('/artikels/' . $artikel->slug . '/edit');
        $this->assertDatabaseHas('artikels', [
            'id' => $artikel->id,
            'judul' => 'tes updated',
        ]);
    }

    /** @test */
    public function test_destroy_artikel()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $artikel = Artikel::create([
            'penulis' => $this->user->id,
            'judul' => 'tes',
            'konten' => 'tes',
            'slug' => 'tes',
            'cover' => UploadedFile::fake()->image('foto.jpg'),
        ]);

        $response = $this->delete('/artikels/' . $artikel->slug);
        $response->assertRedirect('/artikels');
    
        $this->assertDatabaseMissing('artikels', ['id' => $artikel->id]);
    }
}
