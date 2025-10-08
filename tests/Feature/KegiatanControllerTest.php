<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\GajiPegawai;
use App\Models\Kegiatan;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class KegiatanControllerTest extends TestCase
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
    public function test_kegiatan_index_view()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $response = $this->get('/kegiatan');
        $response->assertStatus(200);
        $response->assertViewIs('transaksi.kegiatan.index');
    }

    /** @test */
    public function test_store_kegiatan()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $kegiatan = [
            'pekerjaan_id' => $pekerjaan->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ];

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $pekerjaan->gaji_per_pekerjaan,
        ]);
    
        $response = $this->post('/kegiatan', $kegiatan);

        $response->assertRedirect('/kegiatan');
        $this->assertDatabaseHas('kegiatans', [
            'pekerjaan_id' => $pekerjaan->id,
        ]);
    }

    /** @test */
    public function test_show_kegiatan()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'pekerjaan_id' => $pekerjaan->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $pekerjaan->gaji_per_pekerjaan,
        ]);

        $response = $this->get('/kegiatan/' . $kegiatan->id);
        $response->assertStatus(200);
        $response->assertViewHas('kegiatan', $kegiatan);
    }

    /** @test */
    public function test_update_kegiatan()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);

        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'pekerjaan_id' => $pekerjaan->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $pekerjaan->gaji_per_pekerjaan,
        ]);

        $response = $this->put('/kegiatan/' . $kegiatan->id, [
            'pekerjaan_id' => $pekerjaan->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test updated',
            'kegiatan_dibuat' => now(),
        ]);

        $response->assertRedirect('/kegiatan/' . $kegiatan->id . '/edit');
        $this->assertDatabaseHas('kegiatans', [
            'id' => $kegiatan->id,
            'catatan' => 'test updated',
        ]);
    }

    /** @test */
    public function test_destroy_kegiatan()
    {
        $this->user->assignRole('Pegawai');
        $this->actingAs($this->user);
    
        $pekerjaan = Pekerjaan::create([
            'nama_pekerjaan' => 'tes',
            'gaji_per_pekerjaan' => '1000',
            'deskripsi_pekerjaan' => 'tes',
        ]);

        $kegiatan = Kegiatan::create([
            'pekerjaan_id' => $pekerjaan->id,
            'user_id' => $this->user->id,
            'status_kegiatan' => 'Belum Ditarik',
            'jumlah_kegiatan' => 10,
            'catatan' => 'test',
            'kegiatan_dibuat' => now(),
        ]);

        $gaji_pegawai = GajiPegawai::create([
            'pegawai_id' => $this->user->id,
            'total_gaji_yang_bisa_diajukan' => $kegiatan['jumlah_kegiatan'] * $pekerjaan->gaji_per_pekerjaan,
        ]);

        $response = $this->delete('/kegiatan/' . $kegiatan->id);
        $response->assertRedirect('/kegiatan');
    
        $this->assertDatabaseMissing('kegiatans', ['id' => $kegiatan->id]);
    }
}
