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

class PegawaiControllerTest extends TestCase
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
    public function test_pegawai_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/pegawai');
        $response->assertStatus(200);
        $response->assertViewIs('users.pegawai.index');
    }

    /** @test */
    public function test_store_pegawai()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/pegawai', [
            'nama' => 'Dharu',
            'alamat' => 'Indonesia',
            'email' => 'dharu@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);

        $response->assertRedirect('/pegawai');
        $this->assertDatabaseHas('users', [
            'email' => 'dharu@example.com',
        ]);
    }

    /** @test */
    public function test_show_pegawai()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $pegawai = $this->user;

        $gaji_pegawai = new GajiPegawai();
        $gaji_pegawai->pegawai_id = $pegawai->id; 
        $gaji_pegawai->total_gaji_yang_bisa_diajukan = 0;  
        $gaji_pegawai->terhitung_tanggal = now();   
        $gaji_pegawai->save();

        $response = $this->get('/pegawai/' . $pegawai->id);
        $response->assertStatus(200);
        $response->assertViewHas('pegawai', $pegawai);
    }

    /** @test */
    public function test_update_pegawai()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $pegawai = $this->user;

        $response = $this->put('/pegawai/' . $pegawai->id, [
            'nama' => 'Updated Name',
            'alamat' => $pegawai->alamat,
            'email' => $pegawai->email,
            'password' => $pegawai->password,
            'no_telepon' => $pegawai->no_telepon,
            'jenis_kelamin' => $pegawai->jenis_kelamin,
            'tanggal_lahir' => $pegawai->tanggal_lahir,
        ]);

        $response->assertRedirect('/pegawai/' . $pegawai->id . '/edit');
        $this->assertDatabaseHas('users', [
            'id' => $pegawai->id,
            'nama' => 'Updated Name',
        ]);
    }

    /** @test */
    public function test_destroy_pegawai()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $pegawai = $this->user;
    
        $response = $this->delete('/pegawai/' . $pegawai->id);
        $response->assertRedirect('/pegawai');
    
        $this->assertDatabaseMissing('users', ['id' => $pegawai->id]);
    }
}
