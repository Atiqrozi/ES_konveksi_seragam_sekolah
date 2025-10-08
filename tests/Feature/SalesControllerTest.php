<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Database\Seeders\PermissionsSeeder;

class SalesControllerTest extends TestCase
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
    public function test_sales_index_view()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->get('/sales');
        $response->assertStatus(200);
        $response->assertViewIs('users.sales.index');
    }

    /** @test */
    public function test_store_sales()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $response = $this->post('/sales', [
            'nama' => 'Dharu',
            'alamat' => 'Indonesia',
            'email' => 'dharu@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);

        $response->assertRedirect('/sales');
        $this->assertDatabaseHas('users', [
            'email' => 'dharu@example.com',
        ]);
    }

    /** @test */
    public function test_show_sales()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $sales = $this->user;

        $response = $this->get('/sales/' . $sales->id);
        $response->assertStatus(200);
        $response->assertViewHas('sale', $sales);
    }

    /** @test */
    public function test_update_sales()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);

        $sales = $this->user;

        $response = $this->put('/sales/' . $sales->id, [
            'nama' => 'Updated Name',
            'alamat' => $sales->alamat,
            'email' => $sales->email,
            'password' => $sales->password,
            'no_telepon' => $sales->no_telepon,
            'jenis_kelamin' => $sales->jenis_kelamin,
            'tanggal_lahir' => $sales->tanggal_lahir,
        ]);

        $response->assertRedirect('/sales/' . $sales->id . '/edit');
        $this->assertDatabaseHas('users', [
            'id' => $sales->id,
            'nama' => 'Updated Name',
        ]);
    }


    /** @test */
    public function test_destroy_sales()
    {
        $this->user->assignRole('Admin');
        $this->actingAs($this->user);
    
        $sales = $this->user;
    
        $response = $this->delete('/sales/' . $sales->id);
        $response->assertRedirect('/sales');
    
        $this->assertDatabaseMissing('users', ['id' => $sales->id]);
    }
}
