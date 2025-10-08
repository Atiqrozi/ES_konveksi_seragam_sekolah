<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class RoleControllerTest extends TestCase
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
    public function test_role_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/roles');
        $response->assertStatus(200);
        $response->assertViewIs('r&p.roles.index');
    }

    /** @test */
    public function test_store_role()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
        
        $response = $this->post('/roles', [
            'name' => 'Test Role',
            'permissions' => [],
        ]);

        $response->assertRedirect('/roles');
        $this->assertDatabaseHas('roles', [
            'name' => 'Test Role',
        ]);
    }

    /** @test */
    public function test_show_role()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $role = Role::create([
            'name' => 'Test Role',
            'permissions' => [],
        ]);

        $response = $this->get('/roles/' . $role->id);
        $response->assertStatus(200);
        $response->assertViewHas('role', $role);
    }

    /** @test */
    public function test_update_role()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $role = Role::create([
            'name' => 'Test Role',
            'permissions' => [],
        ]);

        $response = $this->put('/roles/' . $role->id, [
            'name' => 'Updated Role',
            'permissions' => [],
        ]);

        $response->assertRedirect('/roles/' . $role->id . '/edit');
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => 'Updated Role',
        ]);
    }

    /** @test */
    public function test_destroy_role()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $role = Role::create([
            'name' => 'Test Role',
            'permissions' => [],
        ]);

        $response = $this->delete('/roles/' . $role->id);
        $response->assertRedirect('/roles');
    
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
