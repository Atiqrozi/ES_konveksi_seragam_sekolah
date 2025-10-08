<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pekerjaan;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\GajiPerProduk;
use App\Models\GajiPegawai;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\KegiatanStoreRequest;
use App\Http\Requests\KegiatanUpdateRequest;
use App\Exports\Kegiatan_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Kegiatan::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $kegiatans = Kegiatan::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('pekerjaan', function ($query) use ($search) {
                    $query->where('nama_pekerjaan', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->with('pekerjaan')
            ->with('user');

        // Tambahkan filter user_id hanya jika bukan admin
        if (!Auth::user()->hasRole('Admin')) {
            $kegiatans->where('user_id', Auth::user()->id);
        }

        // Sorting
        if ($sortBy === 'kegiatan') {
            $kegiatans = $kegiatans->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
                ->orderBy('pekerjaans.nama_pekerjaan', $sortDirection);
        } elseif ($sortBy === 'nama_pegawai') {
            $kegiatans = $kegiatans->join('users', 'kegiatans.user_id', '=', 'users.id')
                ->orderBy('users.nama', $sortDirection);
        } else {
            $kegiatans = $kegiatans->orderBy($sortBy, $sortDirection);
        }

        // Filter status kegiatan
        $kegiatans = $kegiatans->where('status_kegiatan', 'LIKE', 'Belum Ditarik')
                            ->paginate($paginate)
                            ->withQueryString();

        return view('transaksi.kegiatan.index', compact('kegiatans', 'search', 'sortBy', 'sortDirection'));
    }


    public function create(Request $request): View
    {
        $this->authorize('create', Kegiatan::class);

        $pekerjaans = Pekerjaan::pluck('nama_pekerjaan', 'id');
        $nama_pegawai = User::whereHas('roles', function ($q) {
            $q->where('name', 'Pegawai');
        })->get();

        return view('transaksi.kegiatan.create', compact('pekerjaans', 'nama_pegawai'));
    }


    public function store(KegiatanStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Kegiatan::class);

        $validated = $request->validated();

        $kegiatan = Kegiatan::create($validated);

        $pegawai_id = Auth::user()->hasRole('Admin') ? $validated['user_id'] : Auth::user()->id;
        $user = GajiPegawai::firstOrCreate(['pegawai_id' => $pegawai_id], ['total_gaji_yang_bisa_diajukan' => 0]);

        $user->total_gaji_yang_bisa_diajukan += $kegiatan->jumlah_kegiatan * $kegiatan->pekerjaan->gaji_per_pekerjaan;
        $user->save();

        return redirect()
            ->route('kegiatan.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function edit(Request $request, Kegiatan $kegiatan): View
    {
        $this->authorize('update', $kegiatan);

        $pekerjaans = Pekerjaan::pluck('nama_pekerjaan', 'id');
        $nama_pegawai = User::whereHas('roles', function ($q) {
            $q->where('name', 'Pegawai');
        })->get();

        return view('transaksi.kegiatan.edit', compact('kegiatan', 'pekerjaans', 'nama_pegawai'));
    }


    public function update(KegiatanUpdateRequest $request, Kegiatan $kegiatan): RedirectResponse
    {
        $this->authorize('update', $kegiatan);

        $validated = $request->validated();

        $pegawaiId = Auth::user()->hasRole('Admin') ? $validated['user_id'] : Auth::user()->id;

        $user = GajiPegawai::firstOrCreate(
            ['pegawai_id' => $pegawaiId],
            ['total_gaji_yang_bisa_diajukan' => 0]
        );

        // Kurangi gaji lama
        $user->total_gaji_yang_bisa_diajukan -= $kegiatan->jumlah_kegiatan * $kegiatan->pekerjaan->gaji_per_pekerjaan;

        $kegiatan->update($validated);

        // Tambahkan gaji baru
        $user->total_gaji_yang_bisa_diajukan += $kegiatan->jumlah_kegiatan * $kegiatan->pekerjaan->gaji_per_pekerjaan;
        $user->save();

        return redirect()
            ->route('kegiatan.edit', $kegiatan)
            ->withSuccess(__('crud.common.saved'));
    }


    public function show(Request $request, Kegiatan $kegiatan): View
    {
        $this->authorize('view', $kegiatan);

        $kegiatans = Kegiatan::where('id', $kegiatan->id)->get();

        return view('transaksi.kegiatan.show', compact('kegiatan', 'kegiatans'));
    }


    public function destroy(Request $request, Kegiatan $kegiatan): RedirectResponse
    {
        $this->authorize('delete', $kegiatan);

        $pegawaiId = Auth::user()->hasRole('Admin') ? $kegiatan->user_id : Auth::user()->id;

        $user = GajiPegawai::firstOrCreate(
            ['pegawai_id' => $pegawaiId],
            ['total_gaji_yang_bisa_diajukan' => 0]
        );

        $user->total_gaji_yang_bisa_diajukan -= $kegiatan->jumlah_kegiatan * $kegiatan->pekerjaan->gaji_per_pekerjaan;
        $user->save();

        $kegiatan->delete();

        return redirect()
            ->route('kegiatan.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
