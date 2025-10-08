<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'admin' => [
                'list admin',
                'view admin',
                'create admin',
                'update admin',
                'delete admin',
            ],
            'pegawai' => [
                'list pegawai',
                'view pegawai',
                'create pegawai',
                'update pegawai',
                'delete pegawai',
            ],
            'sales' => [
                'list sales',
                'view sales',
                'create sales',
                'update sales',
                'delete sales',
            ],
            'pelamar' => [
                'list pelamar',
                'view pelamar',
                'create pelamar',
                'update pelamar',
                'delete pelamar',
            ],
            'kriteria' => [
                'list kriteria',
                'view kriteria',
                'create kriteria',
                'update kriteria',
                'delete kriteria',
            ],
            'riwayat_pelamar' => [
                'list riwayat pelamar',
                'view riwayat pelamar',
            ],
            'posisi_lowongan' => [
                'list posisi lowongan',
                'view posisi lowongan',
                'create posisi lowongan',
                'update posisi lowongan',
                'delete posisi lowongan',
            ],
            'pekerjaans' => [
                'list pekerjaans',
                'view pekerjaans',
                'create pekerjaans',
                'update pekerjaans',
                'delete pekerjaans',
            ],
            'produk' => [
                'list produk',
                'view produk',
                'create produk',
                'update produk',
                'delete produk',
            ],
            'ukuran_produk' => [
                'list ukuran produk',
                'view ukuran produk',
                'create ukuran produk',
                'update ukuran produk',
                'delete ukuran produk',
            ],
            'artikel' => [
                'list artikel',
                'view artikel',
                'create artikel',
                'update artikel',
                'delete artikel',
            ],
            'calon_mitra' => [
                'list calon mitra',
                'view calon mitra',
            ],
            'stok_masuk' => [
                'list riwayat stok produk',
                'view riwayat stok produk',
                'create riwayat stok produk',
            ],
            'pesanan' => [
                'list pesanan',
                'view pesanan',
                'create pesanan',
                'delete pesanan',
            ],
            'kegiatan' => [
                'list kegiatan',
                'view kegiatan',
                'create kegiatan',
                'delete kegiatan',
                'update kegiatan',
            ],
            'riwayat_kegiatan_admin' => [
                'list riwayat kegiatan admin',
                'view riwayat kegiatan admin',
            ],
            'riwayat_kegiatan_pegawai' => [
                'list riwayat kegiatan pegawai',
                'view riwayat kegiatan pegawai',
            ],
            'gaji' => [
                'list gaji semua pegawai',
                'view gaji semua pegawai',
            ],
            'pengajuan_penarikan_gaji' => [
                'list pengajuan penarikan gaji',
                'view pengajuan penarikan gaji',
                'create pengajuan penarikan gaji',
                'delete pengajuan penarikan gaji',
            ],
            'konfirmasi_penarikan_gaji' => [
                'list konfirmasi penarikan gaji',
                'terima ajuan penarikan gaji',
                'tolak ajuan penarikan gaji',
            ],
            'riwayat_semua_ajuan' => [
                'list riwayat semua ajuan',
                'view riwayat semua ajuan',
            ],
            'absensi' => [
                'list absensi',
                'view absensi',
                'create absensi',
                'delete absensi',
            ],
            'pengeluaran' => [
                'list pengeluaran',
                'view pengeluaran',
                'create pengeluaran',
                'update pengeluaran',
                'delete pengeluaran',
            ],
            'jenis_pengeluaran' => [
                'list jenis pengeluaran',
                'view jenis pengeluaran',
                'create jenis pengeluaran',
                'update jenis pengeluaran',
                'delete jenis pengeluaran',
            ],
            'kategori' => [
                'list kategori',
                'view kategori',
                'create kategori',
                'update kategori',
                'delete kategori',
            ],
            'roles' => [
                'list roles',
                'view roles',
                'create roles',
                'update roles',
                'delete roles',
            ],
            'permissions' => [
                'list permissions',
                'view permissions',
                'create permissions',
                'update permissions',
                'delete permissions',
            ],
        ];

        // Create permissions
        foreach ($permissions as $group => $perms) {
            foreach ($perms as $perm) {
                Permission::create(['name' => $perm]);
            }
        }

        // Assign all permissions to Admin role
        $admin_permissions = Permission::whereIn('name', array_merge(
            $permissions['admin'],
            $permissions['pegawai'],
            $permissions['sales'],
            $permissions['pelamar'],
            $permissions['kriteria'],
            $permissions['riwayat_pelamar'],
            $permissions['posisi_lowongan'],
            $permissions['pekerjaans'],
            $permissions['produk'],
            $permissions['ukuran_produk'],
            $permissions['artikel'],
            $permissions['calon_mitra'],
            $permissions['stok_masuk'],
            $permissions['pesanan'],
            $permissions['riwayat_kegiatan_admin'],
            $permissions['gaji'],
            $permissions['konfirmasi_penarikan_gaji'],
            $permissions['riwayat_semua_ajuan'],
            $permissions['roles'],
            $permissions['permissions'],
            $permissions['kegiatan'],
            $permissions['pengeluaran'],
            $permissions['jenis_pengeluaran'],
            $permissions['kategori'],
            ['list absensi', 'view absensi'],
        ))->get();
        $admin_role = Role::create(['name' => 'Admin']);
        $admin_role->givePermissionTo($admin_permissions);

        // Assign specific permissions to Pegawai role
        $pegawai_permissions = Permission::whereIn('name', array_merge(
            $permissions['kegiatan'],
            $permissions['riwayat_kegiatan_pegawai'],
            $permissions['pengajuan_penarikan_gaji'],
            $permissions['absensi'],
        ))->get();
        $pegawai_role = Role::create(['name' => 'Pegawai']);
        $pegawai_role->givePermissionTo($pegawai_permissions);

        // Assign specific permissions to Sales role
        $sales_permissions = Permission::whereIn('name', [
            'list pesanan',
            'view pesanan'
        ])->get();
        $sales_role = Role::create(['name' => 'Sales']);
        $sales_role->givePermissionTo($sales_permissions);
    }
}
