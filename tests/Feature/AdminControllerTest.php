<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class AdminControllerTest extends TestCase
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
    public function test_admin_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/admin');
        $response->assertStatus(200);
        $response->assertViewIs('users.admin.index');
    }

    /** @test */
    public function test_store_admin()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/admin', [
            'nama' => 'Dharu',
            'alamat' => 'Indonesia',
            'email' => 'dharu@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);

        $response->assertRedirect('/admin');
        $this->assertDatabaseHas('users', [
            'email' => 'dharu@example.com',
        ]);
    }

    /** @test */
    public function test_show_admin()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $admin = $this->user;

        $response = $this->get('/admin/' . $admin->id);
        $response->assertStatus(200);
        $response->assertViewHas('admin', $admin);
    }

    /** @test */
    public function test_update_admin()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $admin = $this->user;

        $response = $this->put('/admin/' . $admin->id, [
            'nama' => 'Updated Name',
            'alamat' => $admin->alamat,
            'email' => $admin->email,
            'password' => $admin->password,
            'no_telepon' => $admin->no_telepon,
            'jenis_kelamin' => $admin->jenis_kelamin,
            'tanggal_lahir' => $admin->tanggal_lahir,
        ]);

        $response->assertRedirect('/admin/' . $admin->id . '/edit');
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'nama' => 'Updated Name',
        ]);
    }

    /** @test */
    public function test_destroy_admin()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $admin = $this->user;

        $response = $this->delete('/admin/' . $admin->id);
        $response->assertRedirect('/admin');
    
        $this->assertDatabaseMissing('users', ['id' => $admin->id]);
    }
}
