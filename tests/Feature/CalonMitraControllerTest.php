<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\CalonMitra;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class CalonMitraControllerTest extends TestCase
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
    public function test_store_calon_mitra()
    {
        $response = $this->post('/calon-mitra', [
            'nama' => 'tes',
            'nomor_wa' => 'tes',
            'alamat' => 'tes',
        ]);

        $response->assertRedirect('/#kontak');
        $this->assertDatabaseHas('calon_mitras', [
            'nama' => 'tes',
        ]);
    }

    /** @test */
    public function test_show_calon_mitra()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $calon_mitra = CalonMitra::create([
            'nama' => 'tes',
            'nomor_wa' => 'tes',
            'alamat' => 'tes',
        ]);

        $response = $this->get('/calon_mitra/' . $calon_mitra->id);
        $response->assertStatus(200);
        $response->assertViewHas('calon_mitra', $calon_mitra);
    }
}
