<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PosisiLowongan;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class PosisiLowonganControllerTest extends TestCase
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
    public function test_posisi_lowongan_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/posisi_lowongan');
        $response->assertStatus(200);
        $response->assertViewIs('hiring.posisi_lowongan.index');
    }

    /** @test */
    public function test_store_posisi_lowongan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/posisi_lowongan', [
            'nama_posisi' => 'tes',
            'deskripsi_posisi' => 'tes',
        ]);

        $response->assertRedirect('/posisi_lowongan');
        $this->assertDatabaseHas('posisi_lowongans', [
            'nama_posisi' => 'tes',
        ]);
    }

    /** @test */
    public function test_show_posisi_lowongan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $posisi_lowongan = PosisiLowongan::create([
            'nama_posisi' => 'tes',
            'deskripsi_posisi' => 'tes',
        ]);

        $response = $this->get('/posisi_lowongan/' . $posisi_lowongan->id);
        $response->assertStatus(200);
        $response->assertViewHas('posisi_lowongan', $posisi_lowongan);
    }

    /** @test */
    public function test_update_posisi_lowongan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $posisi_lowongan = PosisiLowongan::create([
            'nama_posisi' => 'tes',
            'deskripsi_posisi' => 'tes',
        ]);

        $response = $this->put('/posisi_lowongan/' . $posisi_lowongan->id, [
            'nama_posisi' => 'tes updated',
            'deskripsi_posisi' => $posisi_lowongan->deskripsi_posisi,
        ]);

        $response->assertRedirect('/posisi_lowongan/' . $posisi_lowongan->id . '/edit');
        $this->assertDatabaseHas('posisi_lowongans', [
            'id' => $posisi_lowongan->id,
            'nama_posisi' => 'tes updated',
        ]);
    }

    /** @test */
    public function test_destroy_posisi_lowongan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $posisi_lowongan = PosisiLowongan::create([
            'nama_posisi' => 'tes',
            'deskripsi_posisi' => 'tes',
        ]);

        $response = $this->delete('/posisi_lowongan/' . $posisi_lowongan->id);
        $response->assertRedirect('/posisi_lowongan');
    
        $this->assertDatabaseMissing('posisi_lowongans', ['id' => $posisi_lowongan->id]);
    }
}
