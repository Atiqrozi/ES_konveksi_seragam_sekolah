<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Migrasi database
        $this->artisan('migrate');

        // Membuat role admin
        $role = Role::create(['name' => 'Admin']);

        // Membuat pengguna untuk pengujian
        $this->user = User::factory()->create([
            'nama' => 'test',
            'alamat' => 'Indonesia',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'no_telepon' => '1234567890',
            'jenis_kelamin' => 'Laki-Laki',
            'tanggal_lahir' => now(),
        ]);

        // Menginisiasi user dengan role admin
        $this->user->assignRole($role);
    }

    public function test_login_dengan_inputan_yang_benar(): void
    {
        // Kirim permintaan login dengan inputan yang benar
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        // Verifikasi bahwa pengguna diarahkan ke halaman menu
        $response->assertRedirect('/menu');
        $this->assertAuthenticatedAs($this->user);
        $response->assertStatus(302); // Redirect status
    }

    public function test_login_dengan_inputan_yang_salah(): void
    {
        // Kirim permintaan login dengan inputan yang salah
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // Verifikasi bahwa pengguna tetap berada di halaman login
        $response->assertSessionHasErrors();
        $this->assertGuest();
        $response->assertStatus(302); // Redirect status to login page
    }
}
