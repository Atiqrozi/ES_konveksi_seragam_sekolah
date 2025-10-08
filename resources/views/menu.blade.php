<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>

    <div class="py-12 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 1000px; margin-bottom: 40px;">
            <div class="bg-white overflow-hidden sm:rounded-lg" style="box-shadow: 0 0 15px rgb(185, 185, 185)">

                @php
                    $usersMenuVisible = Gate::check('list_admin', App\Models\User::class) || Gate::check('list_pegawai', App\Models\User::class) || Gate::check('list_sales', App\Models\User::class);

                    $hiringMenuVisible = Gate::check('view-any', App\Models\Pelamar::class) || Gate::check('list_riwayat_pelamar', App\Models\Pelamar::class) || Gate::check('view-any', App\Models\Kriteria::class) || Gate::check('view-any', App\Models\PosisiLowongan::class);

                    $masterdataMenuVisible = Gate::check('view-any', App\Models\Pekerjaan::class) || Gate::check('view-any', App\Models\Produk::class) || Gate::check('view-any', App\Models\UkuranProduk::class) || Gate::check('view-any', App\Models\Artikel::class) || Gate::check('view-any', App\Models\CalonMitra::class) || Gate::check('view-any', App\Models\JenisPengeluaran::class) || Gate::check('view-any', App\Models\Kategori::class) || Gate::check('view-any', App\Models\Komponen::class);

                    $biayaProduksiMenuVisible = Auth::user()->hasRole('Admin'); // Hanya untuk Admin

                    $transaksiMenuVisible = Gate::check('view-any', App\Models\Invoice::class) || Gate::check('view-any', App\Models\RiwayatStokProduk::class) || Gate::check('view-any', App\Models\Kegiatan::class) || Gate::check('view-any', App\Models\Pengeluaran::class);

                    $GajiMenuVisible = Gate::check('view-any', App\Models\GajiPegawai::class) || Gate::check('view-any', App\Models\PenarikanGaji::class) || Gate::check('list_ajuan', App\Models\PenarikanGaji::class) || Gate::check('list_riwayat_semua_ajuan', App\Models\PenarikanGaji::class) || Gate::check('list_absensi', App\Models\Absensi::class);

                    $rpMenuVisible = Gate::check('view-any', Spatie\Permission\Models\Role::class) || Gate::check('view-any', Spatie\Permission\Models\Permission::class);
                @endphp

                @if ($usersMenuVisible)
                <div class="w-full flex justify-center">
                    <table class="table-auto" style="margin-bottom: 20px;">
                        <thead>
                            <tr>
                                <th colspan="10" style="text-align: center;">
                                    <div class="judul_menu">USERS</div>
                                    <div style="height: 3px;
                                    background-color:#800000;
                                    width: 70px;
                                    margin: 0 auto 15px auto;"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @can('list_admin', App\Models\User::class)
                                    <td>
                                        <x-dropdown-link href="{{ route('admin.index') }}">
                                            <i class="fa-solid fa-user-tie fa-2x ikon"></i>
                                        </x-dropdown-link>
                                        <div style="text-align: center; font-size: 13px;">Admin</div>
                                    </td>
                                @endcan
                                @can('list_pegawai', App\Models\User::class)
                                    <td>
                                        <x-dropdown-link href="{{ route('pegawai.index') }}">
                                            <i class="fa-solid fa-users fa-2x ikon"></i>
                                        </x-dropdown-link>
                                        <div style="text-align: center; font-size: 13px;">Pegawai</div>
                                    </td>
                                @endcan
                                @can('list_sales', App\Models\User::class)
                                    <td>
                                        <x-dropdown-link href="{{ route('sales.index') }}">
                                            <i class="fa-solid fa-handshake fa-2x ikon"></i>
                                        </x-dropdown-link>
                                        <div style="text-align: center; font-size: 13px;">Sales</div>
                                    </td>
                                @endcan
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif

                @if ($hiringMenuVisible)
                <div class="w-full flex justify-center">
                    <table class="table-auto" style="margin-bottom: 20px;">
                        <thead>
                            <tr>
                                <th colspan="10" style="text-align: center;">
                                    <div class="judul_menu">HIRING</div>
                                    <div style="height: 2px;
                                    background-color:#800000;
                                    width: 70px;
                                    margin: 0 auto 15px auto;"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @can('view-any', App\Models\Pelamar::class)
                                    <td>
                                        <x-dropdown-link href="{{ route('pelamar.index') }}">
                                            <i class="fa-solid fa-user-plus fa-2x ikon"></i>
                                        </x-dropdown-link>
                                        <div style="text-align: center; font-size: 13px;">Pelamar</div>
                                    </td>
                                @endcan
                                @can('view-any', App\Models\Kriteria::class)
                                    <td>
                                        <x-dropdown-link href="{{ route('kriteria.index') }}">
                                            <i class="fa-solid fa-user-pen fa-2x ikon"></i>
                                        </x-dropdown-link>
                                        <div style="text-align: center; font-size: 13px;">Kriteria</div>
                                    </td>
                                @endcan
                                @can('list_riwayat_pelamar', App\Models\Pelamar::class)
                                    <td>
                                        <x-dropdown-link href="{{ route('riwayat_pelamar.index') }}">
                                            <i class="fa-solid fa-user-clock fa-2x ikon"></i>
                                        </x-dropdown-link>
                                        <div style="text-align: center; font-size: 13px;">Riwayat Pelamar</div>
                                    </td>
                                @endcan
                                @can('view-any', App\Models\PosisiLowongan::class)
                                    <td>
                                        <x-dropdown-link href="{{ route('posisi_lowongan.index') }}">
                                            <i class="fa-solid fa-id-badge fa-2x ikon"></i>
                                        </x-dropdown-link>
                                        <div style="text-align: center; font-size: 13px;">Posisi Lowongan</div>
                                    </td>
                                @endcan
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif

                @if ($masterdataMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">MASTERDATA</div>
                                        <div style="height: 3px;
                                        background-color:#800000;
                                        width: 70px;
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-any', App\Models\JenisPengeluaran::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('jenis_pengeluaran.index') }}">
                                                <i class="fa-solid fa-tags fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Jenis Pengeluaran</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Pekerjaan::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('pekerjaans.index') }}">
                                                <i class="fa-solid fa-rectangle-list fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Pekerjaan</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Kategori::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('kategoris.index') }}">
                                                <i class="fa-solid fa-list fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Kategori Produk</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Produk::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('produks.index') }}">
                                                <i class="fa-solid fa-box-open fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Produk</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\UkuranProduk::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('ukuran_produk.index') }}">
                                                <i class="fa-solid fa-ruler fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Ukuran Produk</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Artikel::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('artikels.index') }}">
                                                <i class="fa-solid fa-newspaper fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Artikel</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\CalonMitra::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('calon_mitra.index') }}">
                                                <i class="fa-solid fa-handshake fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Calon Mitra</div>
                                        </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- BIAYA PRODUKSI SECTION -->
                @if($biayaProduksiMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">BIAYA PRODUKSI</div>
                                        <div style="height: 3px;
                                        background-color:#800000;
                                        width: 70px;
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @if(Auth::user()->hasRole('Admin'))
                                        <td>
                                            <x-dropdown-link href="{{ route('komponen.index') }}">
                                                <i class="fa-solid fa-cubes fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Biaya Komponen</div>
                                        </td>
                                        <td>
                                            <x-dropdown-link href="{{ route('biaya-produk.index') }}">
                                                <i class="fa-solid fa-calculator fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Biaya Total Produk</div>
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($transaksiMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">TRANSAKSI</div>
                                        <div style="height: 2px;
                                        background-color:#800000;
                                        width: 70px;
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-any', App\Models\Pengeluaran::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('pengeluaran.index') }}">
                                                <i class="fa-solid fa-money-bill-wave fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Pengeluaran</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\RiwayatStokProduk::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('riwayat_stok_produk.index') }}">
                                                <i class="fa-solid fa-box-open fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Stok Masuk</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Invoice::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('invoice.index') }}">
                                                <i class="fa-solid fa-basket-shopping fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Pesanan</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Kegiatan::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('kegiatan.index') }}">
                                                <i class="fa-solid fa-clipboard-check fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Kegiatan</div>
                                        </td>
                                    @endcan
                                    @can('list_riwayat_kegiatan_pegawai', App\Models\Kegiatan::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('riwayat_kegiatan_pegawai.index') }}">
                                                <i class="fa-solid fa-clock-rotate-left fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Riwayat Kegiatan</div>
                                        </td>
                                    @endcan
                                    @can('list_riwayat_kegiatan_admin', App\Models\Kegiatan::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('riwayat_kegiatan_admin.index') }}">
                                                <i class="fa-solid fa-clock-rotate-left fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Riwayat Kegiatan</div>
                                        </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($GajiMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">GAJI</div>
                                        <div style="height: 3px;
                                        background-color:#800000;
                                        width: 70px;
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-any', App\Models\Absensi::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('absensis.index') }}">
                                                <i class="fa-solid fa-clock fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Absensi</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\GajiPegawai::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('gaji_semua_pegawai.index') }}">
                                                <i class="fa-solid fa-sack-dollar fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Gaji Pegawai</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\PenarikanGaji::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('pengajuan_penarikan_gaji.index') }}">
                                                <i class="fa-solid fa-hand-holding-dollar fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Penarikan Gaji</div>
                                        </td>
                                    @endcan
                                    @can('list_ajuan', App\Models\PenarikanGaji::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('konfirmasi_penarikan_gaji.index') }}">
                                                <i class="fa-solid fa-sack-xmark fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Konfirmasi Gaji</div>
                                        </td>
                                    @endcan
                                    @can('list_riwayat_semua_ajuan', App\Models\PenarikanGaji::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('riwayat_penarikan_gaji.index') }}">
                                                <i class="fa-solid fa-money-bill-transfer fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Riwayat Gaji</div>
                                        </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($rpMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">R&P</div>
                                        <div style="height: 2px;
                                        background-color:#800000;
                                        width: 70px;
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-any', Spatie\Permission\Models\Role::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('roles.index') }}">
                                                <i class="fa-solid fa-users-gear fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Roles</div>
                                        </td>
                                    @endcan
                                    @can('view-any', Spatie\Permission\Models\Permission::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('permissions.index') }}">
                                                <i class="fa-solid fa-road-barrier fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Permissions</div>
                                        </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
