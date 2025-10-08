<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kegiatan;
use App\Models\Pekerjaan;
use App\Models\GajiPegawai;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class RiwayatKegiatanControllerTest extends TestCase
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
    public function test_riwayat_kegiatan_admin_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/riwayat_kegiatan_admin');
        $response->assertStatus(200);
        $response->assertViewIs('transaksi.riwayat_kegiatan_admin.index');
    }

    /** @test */
    public function test_show_riwayat_kegiatan_admin()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'pekerjaan_id' => $pekerjaan->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Sudah Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $pekerjaan->gaji_per_pekerjaan,
        ]);

        $response = $this->get('/riwayat_kegiatan_admin/' . $kegiatan->id);
        $response->assertStatus(200);
        $response->assertViewHas('riwayat_kegiatan_admin', $kegiatan);
    }
}
