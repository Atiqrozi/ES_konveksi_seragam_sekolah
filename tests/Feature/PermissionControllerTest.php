<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class PermissionControllerTest extends TestCase
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
    public function test_permission_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/permissions');
        $response->assertStatus(200);
        $response->assertViewIs('r&p.permissions.index');
    }

    /** @test */
    public function test_store_permission()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
        
        $response = $this->post('/permissions', [
            'name' => 'Test permission',
            'roles' => [],
        ]);

        $response->assertRedirect('/permissions');
        $this->assertDatabaseHas('permissions', [
            'name' => 'Test permission',
        ]);
    }

    /** @test */
    public function test_show_permission()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $permission = Permission::create([
            'name' => 'Test permission',
            'roles' => [],
        ]);

        $response = $this->get('/permissions/' . $permission->id);
        $response->assertStatus(200);
        $response->assertViewHas('permission', $permission);
    }

    /** @test */
    public function test_update_permission()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $permission = Permission::create([
            'name' => 'Test permission',
            'roles' => [],
        ]);

        $response = $this->put('/permissions/' . $permission->id, [
            'name' => 'Updated permission',
            'roles' => [],
        ]);

        $response->assertRedirect('/permissions/' . $permission->id . '/edit');
        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'name' => 'Updated permission',
        ]);
    }

    /** @test */
    public function test_destroy_permission()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $permission = Permission::create([
            'name' => 'Test Role',
            'roles' => [],
        ]);

        $response = $this->delete('/permissions/' . $permission->id);
        $response->assertRedirect('/permissions');
    
        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }
}
