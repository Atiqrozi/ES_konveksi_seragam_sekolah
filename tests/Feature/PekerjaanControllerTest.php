<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pekerjaan;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class PekerjaanControllerTest extends TestCase
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
    public function test_pekerjaan_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/pekerjaans');
        $response->assertStatus(200);
        $response->assertViewIs('masterdata.pekerjaans.index');
    }

    /** @test */
    public function test_store_pekerjaan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/pekerjaans', [
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $response->assertRedirect('/pekerjaans');
        $this->assertDatabaseHas('pekerjaans', [
            'nama_pekerjaan' => 'tes',
        ]);
    }

    /** @test */
    public function test_show_pekerjaan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $response = $this->get('/pekerjaans/' . $pekerjaan->id);
        $response->assertStatus(200);
        $response->assertViewHas('pekerjaan', $pekerjaan);
    }

    /** @test */
    public function test_update_pekerjaan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $response = $this->put('/pekerjaans/' . $pekerjaan->id, [
            'nama_pekerjaan' => 'tes updated',
            'gaji_per_pekerjaan' => $pekerjaan->gaji_per_pekerjaan,
            'deskripsi_pekerjaan' => $pekerjaan->deskripsi_pekerjaan,
        ]);

        $response->assertRedirect('/pekerjaans/' . $pekerjaan->id . '/edit');
        $this->assertDatabaseHas('pekerjaans', [
            'id' => $pekerjaan->id,
            'nama_pekerjaan' => 'tes updated',
        ]);
    }

    /** @test */
    public function test_destroy_pekerjaan()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $response = $this->delete('/pekerjaans/' . $pekerjaan->id);
        $response->assertRedirect('/pekerjaans');
    
        $this->assertDatabaseMissing('pekerjaans', ['id' => $pekerjaan->id]);
    }
}
