<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RiwayatStokProdukController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KonfirmasiPesananController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\RiwayatKegiatanPegawaiController;
use App\Http\Controllers\RiwayatKegiatanAdminController;
use App\Http\Controllers\GajiPerProdukController;
use App\Http\Controllers\GajiSemuaPegawaiController;
use App\Http\Controllers\PengajuanPenarikanGajiController;
use App\Http\Controllers\KonfirmasiPenarikanGajiController;
use App\Http\Controllers\RiwayatPenarikanGajiController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\RiwayatPelamarController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\CalonMitraController;
use App\Http\Controllers\UkuranProdukController;
use App\Http\Controllers\PosisiLowonganController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JenisPengeluaranController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomponenController;
use App\Http\Controllers\BiayaProdukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/kategori_produk', [LandingPageController::class, 'kategori_produk']);
Route::get('/produk/kategori/{id}', [LandingPageController::class, 'produk'])->name('kategori.produk');
Route::get('/artikel', [LandingPageController::class, 'artikel']);
Route::get('/artikel/{slug}', [LandingPageController::class, 'show'])->name('artikel.show');

Route::post('/calon-mitra', [CalonMitraController::class, 'store'])->name('calon_mitra.store');


Route::get('/rekrut', [PelamarController::class, 'create'])->name('ajukan_lamaran');
Route::post('/rekrut', [PelamarController::class, 'store'])->name('pelamar.store');

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/menu', function () {
        return view('menu');
    })
    ->name('menu');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {

        // export admin
        Route::get('/admin/export_excel', [AdminController::class, 'export_excel'])->name('admin.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list admin']);
        Route::get('/admin/export_pdf', [AdminController::class, 'export_pdf'])->name('admin.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list admin']);

        // export pegawai
        Route::get('/pegawai/export_excel', [PegawaiController::class, 'export_excel'])->name('pegawai.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pegawai']);
        Route::get('/pegawai/export_pdf', [PegawaiController::class, 'export_pdf'])->name('pegawai.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list pegawai']);

        // export sales
        Route::get('/sales/export_excel', [SalesController::class, 'export_excel'])->name('sales.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list sales']);
        Route::get('/sales/export_pdf', [SalesController::class, 'export_pdf'])->name('sales.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list sales']);

        // export pelamar
        Route::get('/pelamar/export_excel', [PelamarController::class, 'export_excel'])->name('pelamar.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pelamar']);

        // export riwayat pelamar
        Route::get('/riwayat_pelamar/export_excel', [RiwayatPelamarController::class, 'export_excel'])->name('riwayat_pelamar.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat pelamar']);

        // export pekerjaans
        Route::get('/pekerjaans/export_excel', [PekerjaanController::class, 'export_excel'])->name('pekerjaans.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pekerjaans']);
        Route::get('/pekerjaans/export_pdf', [PekerjaanController::class, 'export_pdf'])->name('pekerjaans.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list pekerjaans']);

        // export produks
        Route::get('/produks/export_excel', [ProdukController::class, 'export_excel'])->name('produks.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list produk']);
        Route::get('/produks/export_pdf', [ProdukController::class, 'export_pdf'])->name('produks.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list produk']);

        // export riwayat stok produk
        Route::get('/riwayat_stok_produk/export_excel', [RiwayatStokProdukController::class, 'export_excel'])->name('riwayat_stok_produk.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat stok produk']);
        Route::get('/riwayat_stok_produk/export_pdf', [RiwayatStokProdukController::class, 'export_pdf'])->name('riwayat_stok_produk.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list riwayat stok produk']);
        Route::get('/riwayat_stok_produk/history', [RiwayatStokProdukController::class, 'history'])->name('riwayat_stok_produk.history')->middleware(['auth', 'verified', 'role_or_permission:list riwayat stok produk']);
        Route::get('/riwayat_stok_produk/stok_keluar', [RiwayatStokProdukController::class, 'stok_keluar'])->name('riwayat_stok_produk.stok_keluar')->middleware(['auth', 'verified', 'role_or_permission:list riwayat stok produk']);

        // export pesanan
        Route::get('/pesanan/export_excel', [PesananController::class, 'export_excel'])->name('pesanan.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pesanan']);
        Route::get('/pesanan/export_pdf', [PesananController::class, 'export_pdf'])->name('pesanan.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list pesanan']);
        Route::get('/pesanan/invoice_pdf/{invoice_id}', [PesananController::class, 'invoice_pdf'])->name('pesanan.invoice_pdf')->middleware(['auth', 'verified', 'role_or_permission:view pesanan']);
        Route::get('/pesanan/invoice_print/{invoice_id}', [PesananController::class, 'invoice_print'])->name('pesanan.invoice_print')->middleware(['auth', 'verified', 'role_or_permission:view pesanan']);

        // export roles
        Route::get('/roles/export_excel', [RoleController::class, 'export_excel'])->name('roles.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list roles']);
        Route::get('/roles/export_pdf', [RoleController::class, 'export_pdf'])->name('roles.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list roles']);

        // export permissions
        Route::get('/permissions/export_excel', [PermissionController::class, 'export_excel'])->name('permissions.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list permissions']);
        Route::get('/permissions/export_pdf', [PermissionController::class, 'export_pdf'])->name('permissions.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list permissions']);

        // export riwayat kegiatan pegawai
        Route::get('/riwayat_kegiatan_pegawai/export_excel', [RiwayatKegiatanPegawaiController::class, 'export_excel'])->name('riwayat_kegiatan_pegawai.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan pegawai']);
        Route::get('/riwayat_kegiatan_pegawai/export_pdf', [RiwayatKegiatanPegawaiController::class, 'export_pdf'])->name('riwayat_kegiatan_pegawai.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan pegawai']);

        // export riwayat kegiatan admin
        Route::get('/riwayat_kegiatan_admin/export_excel', [RiwayatKegiatanAdminController::class, 'export_excel'])->name('riwayat_kegiatan_admin.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan admin']);
        Route::get('/riwayat_kegiatan_admin/export_pdf', [RiwayatKegiatanAdminController::class, 'export_pdf'])->name('riwayat_kegiatan_admin.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan admin']);

        // export gaji per produk
        // Route::get('/gaji_per_produk/export_excel', [GajiPerProdukController::class, 'export_excel'])->name('gaji_per_produk.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list gaji per produk']);
        // Route::get('/gaji_per_produk/export_pdf', [GajiPerProdukController::class, 'export_pdf'])->name('gaji_per_produk.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list gaji per produk']);

        // export gaji semua pegawai
        Route::get('/gaji_semua_pegawai/export_excel', [GajiSemuaPegawaiController::class, 'export_excel'])->name('gaji_semua_pegawai.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list gaji semua pegawai']);
        Route::get('/gaji_semua_pegawai/export_pdf', [GajiSemuaPegawaiController::class, 'export_pdf'])->name('gaji_semua_pegawai.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list gaji semua pegawai']);
        Route::get('/gaji_semua_pegawai/{id}/slip_gaji', [GajiSemuaPegawaiController::class, 'export_slip_gaji'])->name('gaji_semua_pegawai.slip_gaji')->middleware(['auth', 'verified', 'role_or_permission:view gaji semua pegawai']);

        // export pengajuan penarikan gaji
        Route::get('/pengajuan_penarikan_gaji/export_excel', [PengajuanPenarikanGajiController::class, 'export_excel'])->name('pengajuan_penarikan_gaji.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pengajuan penarikan gaji']);
        Route::get('/pengajuan_penarikan_gaji/export_pdf', [PengajuanPenarikanGajiController::class, 'export_pdf'])->name('pengajuan_penarikan_gaji.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list pengajuan penarikan gaji']);
        Route::get('/pengajuan_penarikan_gaji/{id}/export_slip_gaji', [PengajuanPenarikanGajiController::class, 'export_slip_gaji'])->name('pengajuan_penarikan_gaji.export_slip_gaji')->middleware(['auth', 'verified', 'role_or_permission:list pengajuan penarikan gaji']);
        Route::get('/pengajuan_penarikan_gaji/{id}/print_slip_gaji', [PengajuanPenarikanGajiController::class, 'print_slip_gaji'])->name('pengajuan_penarikan_gaji.print_slip_gaji')->middleware(['auth', 'verified', 'role_or_permission:list pengajuan penarikan gaji']);

        // export riwayat penarikan gaji
        Route::get('/riwayat_penarikan_gaji/export_excel', [RiwayatPenarikanGajiController::class, 'export_excel'])->name('riwayat_penarikan_gaji.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat semua ajuan']);
        Route::get('/riwayat_penarikan_gaji/export_pdf', [RiwayatPenarikanGajiController::class, 'export_pdf'])->name('riwayat_penarikan_gaji.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list riwayat semua ajuan']);

        // export kriteria
        Route::get('/kriteria/export_excel', [KriteriaController::class, 'export_excel'])->name('kriteria.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list kriteria']);
        Route::get('/kriteria/export_pdf', [KriteriaController::class, 'export_pdf'])->name('kriteria.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list kriteria']);

        // export calon mitra
        Route::get('/calon_mitra/export_excel', [CalonMitraController::class, 'export_excel'])->name('calon_mitra.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list calon mitra']);
        Route::get('/calon_mitra/export_pdf', [CalonMitraController::class, 'export_pdf'])->name('calon_mitra.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list calon mitra']);

        // export artikel
        Route::get('/artikels/export_excel', [ArtikelController::class, 'export_excel'])->name('artikels.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list artikel']);
        Route::get('/artikels/export_pdf', [ArtikelController::class, 'export_pdf'])->name('artikels.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list artikel']);

        // export ukuran produk
        Route::get('/ukuran_produk/export_excel', [UkuranProdukController::class, 'export_excel'])->name('ukuran_produk.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list ukuran produk']);
        Route::get('/ukuran_produk/export_pdf', [UkuranProdukController::class, 'export_pdf'])->name('ukuran_produk.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list ukuran produk']);

        // export posisi lowongan
        Route::get('/posisi_lowongan/export_excel', [PosisiLowonganController::class, 'export_excel'])->name('posisi_lowongan.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list posisi lowongan']);
        Route::get('/posisi_lowongan/export_pdf', [PosisiLowonganController::class, 'export_pdf'])->name('posisi_lowongan.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list posisi lowongan']);

        // export pengeluaran
        Route::get('/pengeluaran/export_excel', [PengeluaranController::class, 'export_excel'])->name('pengeluaran.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pengeluaran']);
        Route::get('/pengeluaran/export_pdf', [PengeluaranController::class, 'export_pdf'])->name('pengeluaran.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list pengeluaran']);

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('admin', AdminController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('sales', SalesController::class);
        Route::resource('pekerjaans', PekerjaanController::class);
        Route::resource('produks', ProdukController::class);
        Route::resource('riwayat_stok_produk', RiwayatStokProdukController::class);
        Route::resource('invoice', PesananController::class);
        // Route::resource('konfirmasi_pesanan', KonfirmasiPesananController::class);
        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('riwayat_kegiatan_pegawai', RiwayatKegiatanPegawaiController::class);
        Route::resource('riwayat_kegiatan_admin', RiwayatKegiatanAdminController::class);
        // Route::resource('gaji_per_produk', GajiPerProdukController::class);
        Route::resource('gaji_semua_pegawai', GajiSemuaPegawaiController::class);
        Route::resource('pengajuan_penarikan_gaji', PengajuanPenarikanGajiController::class);
        Route::resource('konfirmasi_penarikan_gaji', KonfirmasiPenarikanGajiController::class);
        Route::resource('riwayat_penarikan_gaji', RiwayatPenarikanGajiController::class);
        Route::resource('riwayat_pelamar', RiwayatPelamarController::class);
        Route::resource('kriteria', KriteriaController::class);
        Route::resource('artikels', ArtikelController::class);
        // Route::resource('calon_mitra', CalonMitraController::class);
        Route::resource('ukuran_produk', UkuranProdukController::class);
        Route::resource('posisi_lowongan', PosisiLowonganController::class);
        Route::resource('absensis', AbsensiController::class);
        Route::resource('jenis_pengeluaran', JenisPengeluaranController::class);
        Route::resource('pengeluaran', PengeluaranController::class);
        Route::resource('kategoris', KategoriController::class);
        
        // Routes untuk fitur biaya - Komponen
        Route::resource('komponen', KomponenController::class);
        
        // Routes untuk fitur biaya - Biaya Produk
        Route::resource('biaya-produk', BiayaProdukController::class)->parameters(['biaya-produk' => 'total_harga']);
        Route::delete('/biaya-produk/{produk}/remove-komponen/{komponen}', [BiayaProdukController::class, 'removeKomponen'])->name('biaya-produk.remove-komponen');
        Route::get('/biaya-produk/{produk}/manage-komponen', [BiayaProdukController::class, 'manageKomponen'])->name('biaya-produk.manage-komponen');
        Route::post('/biaya-produk/{produk}/store-komponen', [BiayaProdukController::class, 'storeKomponen'])->name('biaya-produk.store-komponen');
        Route::patch('/biaya-produk/update-komponen/{produkKomponen}', [BiayaProdukController::class, 'updateKomponen'])->name('biaya-produk.update-komponen');
        Route::delete('/biaya-produk/delete-komponen/{produkKomponen}', [BiayaProdukController::class, 'deleteKomponen'])->name('biaya-produk.delete-komponen');
        Route::patch('/biaya-produk/{produk}/update-harga-from-komponen', [BiayaProdukController::class, 'updateHargaFromKomponen'])->name('biaya-produk.update-harga-from-komponen');

        // Route calon mitra
        Route::get('/calon_mitra', [CalonMitraController::class, 'index'])->name('calon_mitra.index')->middleware(['auth', 'verified', 'role_or_permission:list calon mitra']);
        Route::get('/calon_mitra/{calon_mitra}', [CalonMitraController::class, 'show'])->name('calon_mitra.show')->middleware(['auth', 'verified', 'role_or_permission:view calon mitra']);

        // Route pelamar
        Route::get('/pelamar', [PelamarController::class, 'index'])->name('pelamar.index')->middleware(['auth', 'verified', 'role_or_permission:list pelamar']);
        Route::get('/pelamar/{pelamar}', [PelamarController::class, 'show'])->name('pelamar.show')->middleware(['auth', 'verified', 'role_or_permission:view pelamar']);
        Route::get('/pelamar/{pelamar}/edit', [PelamarController::class, 'edit'])->name('pelamar.edit')->middleware(['auth', 'verified', 'role_or_permission:update pelamar']);
        Route::put('pelamar/{pelamar}/edit', [PelamarController::class, 'update'])->name('pelamar.update')->middleware(['auth', 'verified', 'role_or_permission:update pelamar']);
        Route::delete('pelamar/{pelamar}', [PelamarController::class, 'destroy'])->name('pelamar.destroy')->middleware(['auth', 'verified', 'role_or_permission:delete pelamar']);
        Route::get('/pelamar/{pelamar}/waktu', [PelamarController::class, 'edit_waktu'])->name('pelamar.edit_waktu')->middleware(['auth', 'verified', 'role_or_permission:update pelamar']);
        Route::put('/pelamar/{pelamar}/waktu', [PelamarController::class, 'update_waktu'])->name('pelamar.update_waktu')->middleware(['auth', 'verified', 'role_or_permission:update pelamar']);
        Route::patch('/pelamar/{pelamar}/tolak', [PelamarController::class, 'tolak_lamaran'])->name('pelamar.tolak_lamaran');
        Route::patch('/pelamar/{pelamar}/terima', [PelamarController::class, 'terima_lamaran'])->name('pelamar.terima_lamaran');


        // diagram
        Route::get('/diagram_admin', [AdminController::class, 'diagram'])->name('admin.diagram')->middleware(['auth', 'verified', 'role_or_permission:list admin']);
        Route::get('/diagram_pegawai', [PegawaiController::class, 'diagram'])->name('pegawai.diagram')->middleware(['auth', 'verified', 'role_or_permission:list pegawai']);
        Route::get('/diagram_sales', [SalesController::class, 'diagram'])->name('sales.diagram')->middleware(['auth', 'verified', 'role_or_permission:list sales']);
        Route::get('/diagram_pesanan', [PesananController::class, 'diagram'])->name('invoice.diagram')->middleware(['auth', 'verified', 'role_or_permission:list pesanan']);
        Route::get('/diagram_gaji_pegawai', [GajiSemuaPegawaiController::class, 'diagram'])->name('gaji_semua_pegawai.diagram')->middleware(['auth', 'verified', 'role_or_permission:list gaji semua pegawai']);
        Route::get('/diagram_kegiatan_pegawai', [RiwayatKegiatanPegawaiController::class, 'diagram'])->name('riwayat_kegiatan_pegawai.diagram')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan pegawai']);
        Route::get('/diagram_kegiatan_admin', [RiwayatKegiatanAdminController::class, 'diagram'])->name('riwayat_kegiatan_admin.diagram')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan admin']);
        Route::get('/diagram_pelamar', [PelamarController::class, 'diagram'])->name('pelamar.diagram')->middleware(['auth', 'verified', 'role_or_permission:list pelamar']);
        Route::get('/diagram_riwayat_pelamar', [RiwayatPelamarController::class, 'diagram'])->name('riwayat_pelamar.diagram')->middleware(['auth', 'verified', 'role_or_permission:list riwayat pelamar']);


        // konfirmasi konfirmasi_penarikan_gaji
        Route::patch('/konfirmasi_penarikan_gaji/{konfirmasi_penarikan_gaji}/tolak', [KonfirmasiPenarikanGajiController::class, 'tolak_ajuan'])->name('konfirmasi_penarikan_gaji.tolak_ajuan');
        Route::patch('/konfirmasi_penarikan_gaji/{konfirmasi_penarikan_gaji}/terima', [KonfirmasiPenarikanGajiController::class, 'terima_ajuan'])->name('konfirmasi_penarikan_gaji.terima_ajuan');

        // selesaikan kegiatan
        Route::patch('/kegiatan/{kegiatan}/selesai', [KegiatanController::class, 'selesaikan_kegiatan'])->name('kegiatan.selesai');

        // mengajukan penarikan gaji
        Route::patch('/pengajuan_penarikan_gaji/{gaji_pegawai}/ajukan', [PengajuanPenarikanGajiController::class, 'ajukan'])->name('pengajuan_penarikan_gaji.ajukan');

        // mengupdate waktu recruitment
        Route::patch('/recruitment/{id}', [PelamarController::class, 'open_recruitment'])->name('recruitment.update');
    });
