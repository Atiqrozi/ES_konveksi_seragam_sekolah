<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\GajiPegawai;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class GajiSemuaPegawaiControllerTest extends TestCase
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
    public function test_gaji_pegawai_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/gaji_semua_pegawai');
        $response->assertStatus(200);
        $response->assertViewIs('gaji.gaji_semua_pegawai.index');
    }

    /** @test */
    public function test_show_gaji_pegawai()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => 1000,
        ]);

        $response = $this->get('/gaji_semua_pegawai/' . $gaji_pegawai->id);
        $response->assertStatus(200);
        $response->assertViewHas('gaji_semua_pegawai', $gaji_pegawai);
    }
}
