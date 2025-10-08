<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AbsensiStoreRequest;
use App\Exports\Absensis_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Absensi::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $user = auth()->user();

        $absensis = Absensi::query()
            // Jika bukan admin, hanya tampilkan absensi milik sendiri
            ->when(!$user->hasRole('Admin'), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            // Filter berdasarkan nama jika ada pencarian
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                });
            })
            // Filter berdasarkan rentang tanggal
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59',
                ]);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('gaji.absensis.index', compact('absensis', 'search', 'sortBy', 'sortDirection'));
    }


    public function create(Request $request): View
    {
        $this->authorize('create', Absensi::class);

        return view('gaji.absensis.create');
    }


    public function store(AbsensiStoreRequest $request): RedirectResponse
    {
        /** @var \Illuminate\Http\Request $request */

        $this->authorize('create', Absensi::class);

        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('public/absensi');
        }

        $sbsensi = Absensi::create($validated);

        return redirect()
            ->route('absensis.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, Absensi $absensi): View
    {
        $this->authorize('view', $absensi);

        return view('gaji.absensis.show', compact('absensi'));
    }


    public function destroy(
        Request $request,
        Absensi $absensi
    ): RedirectResponse {
        $this->authorize('delete', $absensi);

        if ($absensi->foto) {
            Storage::delete($absensi->foto);
        }

        $absensi->delete();

        return redirect()
            ->route('absensis.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
