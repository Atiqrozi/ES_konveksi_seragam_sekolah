<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kriteria;
use App\Models\Pelamar;
use App\Models\PosisiLowongan;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Database\Seeders\KriteriaSeeder;

class PelamarControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->seed(PermissionsSeeder::class);
        $this->seed(KriteriaSeeder::class);

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
    public function test_pelamar_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/pelamar');
        $response->assertStatus(200);
        $response->assertViewIs('hiring.pelamar.index');
    }

    /** @test */
    public function test_store_pelamar_apply()
    {
        $posisi_lowongan = PosisiLowongan::create([
            'nama_posisi' => 'tes',
            'deskripsi_posisi' => 'tes',
        ]);

        $response = $this->post('/rekrut', [
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
            'status' => 'Diajukan',
            'weighted_sum_model' => null,
            'mulai_wawancara' => null,
            'selesai_wawancara' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response->assertRedirect('/rekrut');
        $this->assertDatabaseHas('pelamars', [
            'nama' => 'tes',
        ]);
    }

    /** @test */
    public function test_show_pelamar()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

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
            'status' => 'Diajukan',
            'weighted_sum_model' => null,
            'mulai_wawancara' => null,
            'selesai_wawancara' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/pelamar/' . $pelamar->id);
        $response->assertStatus(200);
        $response->assertViewHas('pelamar', $pelamar);
    }

    /** @test */
    public function test_set_waktu_wawancara()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

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
            'status' => 'Diajukan',
            'weighted_sum_model' => null,
            'mulai_wawancara' => null,
            'selesai_wawancara' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mulaiWawancara = Carbon::now()->addDays(1)->format('Y-m-d H:i:s');
        $selesaiWawancara = Carbon::now()->addDays(1)->addHour()->format('Y-m-d H:i:s');

        $response = $this->put('/pelamar/' . $pelamar->id . '/waktu', [
            'mulai_wawancara' => $mulaiWawancara,
            'selesai_wawancara' => $selesaiWawancara,
            'status' => "Belum Wawancara",
        ]);

        $response->assertRedirect('/pelamar/' . $pelamar->id . '/waktu');
        $this->assertDatabaseHas('pelamars', [
            'id' => $pelamar->id,
            'mulai_wawancara' => $mulaiWawancara,
            'selesai_wawancara' => $selesaiWawancara,
            'status' => "Belum Wawancara",
        ]);
    }

    /** @test */
    public function test_memberikan_nilai()
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
            'status' => 'Belum Wawancara',
            'weighted_sum_model' => null,
            'mulai_wawancara' => $mulaiWawancara,
            'selesai_wawancara' => $selesaiWawancara,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $criteria = [
            'pengalaman' => 4,
            'pengetahuan_teknis' => 5,
            'pengalaman_kerja' => 5,
            'kreativitas' => 5,
            'kemampuan_komunikasi' => 5,
            'problem_solving' => 5,
            'kepatuhan_standar' => 5,
            'ambisi' => 5,
            'keterampilan_manajerial' => 5,
        ];

        $response = $this->put('/pelamar/' . $pelamar->id . '/edit', array_merge($criteria, [
            'weighted_sum_model' => 5,
            'status' => "Sudah Wawancara",
        ]));

        $response->assertRedirect('/pelamar/' . $pelamar->id . '/edit');
        $this->assertDatabaseHas('pelamars', [
            'id' => $pelamar->id,
            'weighted_sum_model' => 5,
            'status' => "Sudah Wawancara",
        ]);
    }

    /** @test */
    public function test_menerima_pelamar()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $posisi_lowongan = PosisiLowongan::create([
            'nama_posisi' => 'tes',
            'deskripsi_posisi' => 'tes',
        ]);

        $mulaiWawancara = Carbon::now()->addDays(1)->format('Y-m-d H:i:s');
        $selesaiWawancara = Carbon::now()->addDays(1)->addHour()->format('Y-m-d H:i:s');

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
            'status' => 'Sudah Wawancara',
            'weighted_sum_model' => 5,
            'mulai_wawancara' => $mulaiWawancara,
            'selesai_wawancara' => $selesaiWawancara,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->patch(route('pelamar.terima_lamaran', $pelamar->id), [
            'status' => 'Diterima',
        ]);

        $response->assertRedirect(route('pelamar.index'));
        $this->assertDatabaseHas('pelamars', [
            'id' => $pelamar->id,
            'status' => 'Diterima',
        ]);
    }

    /** @test */
    public function test_menolak_pelamar()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $posisi_lowongan = PosisiLowongan::create([
            'nama_posisi' => 'tes',
            'deskripsi_posisi' => 'tes',
        ]);

        $mulaiWawancara = Carbon::now()->addDays(1)->format('Y-m-d H:i:s');
        $selesaiWawancara = Carbon::now()->addDays(1)->addHour()->format('Y-m-d H:i:s');

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
            'status' => 'Sudah Wawancara',
            'weighted_sum_model' => 5,
            'mulai_wawancara' => $mulaiWawancara,
            'selesai_wawancara' => $selesaiWawancara,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->patch(route('pelamar.tolak_lamaran', $pelamar->id), [
            'status' => 'Ditolak',
        ]);

        $response->assertRedirect(route('pelamar.index'));
        $this->assertDatabaseHas('pelamars', [
            'id' => $pelamar->id,
            'status' => 'Ditolak',
        ]);
    }

    /** @test */
    public function test_destroy_pelamar()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

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
            'status' => 'Diajukan',
            'weighted_sum_model' => null,
            'mulai_wawancara' => null,
            'selesai_wawancara' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->delete('/pelamar/' . $pelamar->id);
        $response->assertRedirect('/pelamar');
    
        $this->assertDatabaseMissing('pelamars', ['id' => $pelamar->id]);
    }
}
