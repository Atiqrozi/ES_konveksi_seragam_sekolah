<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kriteria;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class KriteriaControllerTest extends TestCase
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
    public function test_kriteria_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/kriteria');
        $response->assertStatus(200);
        $response->assertViewIs('hiring.kriteria.index');
    }

    /** @test */
    public function test_store_kriteria()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/kriteria', [
            'nama' => 'tes',
            'bobot' => 0.20,
        ]);

        $response->assertRedirect('/kriteria');
        $this->assertDatabaseHas('kriterias', [
            'nama' => 'tes',
        ]);
    }

    /** @test */
    public function test_show_kriteria()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $kriteria = Kriteria::create([
            'nama' => 'tes',
            'bobot' => 0.20,
        ]);

        $response = $this->get('/kriteria/' . $kriteria->id);
        $response->assertStatus(200);
        $response->assertViewHas('kriterium', $kriteria);
    }

    /** @test */
    public function test_update_kriteria()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $kriteria = Kriteria::create([
            'nama' => 'tes',
            'bobot' => 0.20,
        ]);

        $response = $this->put('/kriteria/' . $kriteria->id, [
            'nama' => 'tes updated',
            'bobot' => 0.20,
        ]);

        $response->assertRedirect('/kriteria/' . $kriteria->id . '/edit');
        $this->assertDatabaseHas('kriterias', [
            'id' => $kriteria->id,
            'nama' => 'tes updated',
        ]);
    }

    /** @test */
    public function test_destroy_kriteria()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $kriteria = Kriteria::create([
            'nama' => 'tes',
            'bobot' => 0.20,
        ]);

        $response = $this->delete('/kriteria/' . $kriteria->id);
        $response->assertRedirect('/kriteria');
    
        $this->assertDatabaseMissing('kriterias', ['id' => $kriteria->id]);
    }
}
