<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pelamar;
use App\Models\PosisiLowongan;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

class RiwayatPelamarControllerTest extends TestCase
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
    public function test_riwayat_pelamar_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/riwayat_pelamar');
        $response->assertStatus(200);
        $response->assertViewIs('hiring.riwayat_pelamar.index');
    }

    /** @test */
    public function test_show_riwayat_pelamar()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $mulaiWawancara = Carbon::now()->addDays(1)->format('Y-m-d H:i:s');
        $selesaiWawancara = Carbon::now()->addDays(1)->addHour()->format('Y-m-d H:i:s');

        $posisi_lowongan = PosisiLowongan::create([
            'nama_posisi' => 'tes',
            'deskripsi_posisi' => 'tes',
        ]);

        $pelamar = Pelamar::create([
            'nama' => 'tes',
            'email' => 'tes@gmail.com',
            'alamat' => 'tes',
            'no_telepon' => 123,
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
            'pendidikan_terakhir' => 'SMA',
            'posisi_id' => $posisi_lowongan->id,
            'tentang_diri' => 'tes',
            'pengalaman' => 'tes',
            'foto' => UploadedFile::fake()->image('foto.jpg'),
            'cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
            'status' => 'Diterima',
            'weighted_sum_model' => 5,
            'mulai_wawancara' => $mulaiWawancara,
            'selesai_wawancara' => $selesaiWawancara,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/riwayat_pelamar/' . $pelamar->id);
        $response->assertStatus(200);
        $response->assertViewHas('riwayat_pelamar', $pelamar);
    }
}
