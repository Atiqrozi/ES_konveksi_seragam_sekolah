<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PenarikanGaji;
use App\Models\GajiPegawai;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class RiwayatPenarikanGajiControllerTest extends TestCase
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
    public function test_riwayat_penarikan_gaji_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/riwayat_penarikan_gaji');
        $response->assertStatus(200);
        $response->assertViewIs('gaji.riwayat_penarikan_gaji.index');
    }

    /** @test */
    public function test_show_riwayat_penarikan_gaji()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => 1000,
            'terhitung_tanggal' => now(),
        ]);

        $penarikan_gaji = PenarikanGaji::create([
            'pegawai_id' => $this->user->id,
            'gaji_yang_diajukan' => 1000,
            'status' => 'Diterima',
            'mulai_tanggal' => now(),
            'akhir_tanggal' => now(),
            'gaji_diberikan' => null,
        ]);

        $response = $this->get('/riwayat_penarikan_gaji/' . $penarikan_gaji->id);
        $response->assertStatus(200);
        $response->assertViewHas('riwayat_penarikan_gaji', $penarikan_gaji);
    }
}
