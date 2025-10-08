<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\JenisPengeluaran;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PengeluaranStoreRequest;
use App\Http\Requests\PengeluaranUpdateRequest;
use App\Exports\Pengeluaran_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Pengeluaran::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'pengeluarans.id');
        $sortDirection = $request->get('sort_direction', 'desc');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $pengeluarans = Pengeluaran::query()
            ->select('pengeluarans.*')
            ->join('jenis_pengeluarans', 'pengeluarans.jenis_pengeluaran_id', '=', 'jenis_pengeluarans.id')
            ->with('jenis_pengeluaran')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('jenis_pengeluarans.nama_pengeluaran', 'LIKE', "%{$search}%")
                      ->orWhere('pengeluarans.keterangan', 'LIKE', "%{$search}%");
                });
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('pengeluarans.tanggal', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59',
                ]);
            })
            ->when($sortBy === 'nama_pengeluaran', function ($query) use ($sortDirection) {
                $query->orderBy('jenis_pengeluarans.nama_pengeluaran', $sortDirection);
            }, function ($query) use ($sortBy, $sortDirection) {
                $query->orderBy($sortBy, $sortDirection);
            })
            ->paginate($paginate)
            ->withQueryString();

        if (!$startDate && !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }

        $query = DB::table('pengeluarans')
            ->join('jenis_pengeluarans', 'pengeluarans.jenis_pengeluaran_id', '=', 'jenis_pengeluarans.id')
            ->when($search, function ($q) use ($search) {
                $q->where('pengeluarans.keterangan', 'like', "%$search%");
            })
            ->when($startDate, function ($q) use ($startDate) {
                $q->whereDate('pengeluarans.tanggal', '>=', $startDate);
            })
            ->when($endDate, function ($q) use ($endDate) {
                $q->whereDate('pengeluarans.tanggal', '<=', $endDate);
            });

        $ringkasanPengeluaran = (clone $query)
            ->select('jenis_pengeluarans.nama_pengeluaran', DB::raw('SUM(pengeluarans.jumlah) as total'))
            ->groupBy('jenis_pengeluarans.nama_pengeluaran')
            ->get();

        $totalPengeluaran = (clone $query)->sum('pengeluarans.jumlah');

        return view('transaksi.pengeluaran.index', compact(
            'pengeluarans',
            'search',
            'sortBy',
            'sortDirection',
            'startDate',
            'endDate',
            'ringkasanPengeluaran',
            'totalPengeluaran',
        ));
    }


    public function create(Request $request): View
    {
        $this->authorize('create', Pengeluaran::class);

        $jenis_pengeluarans = JenisPengeluaran::all();

        return view('transaksi.pengeluaran.create', compact('jenis_pengeluarans'));
    }


    public function store(PengeluaranStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Pengeluaran::class);

        $validated = $request->validated();

        $pengeluaran = Pengeluaran::create($validated);

        return redirect()
            ->route('pengeluaran.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, Pengeluaran $pengeluaran): View
    {
        $this->authorize('view', $pengeluaran);

        return view('transaksi.pengeluaran.show', compact('pengeluaran'));
    }


    public function edit(Request $request, Pengeluaran $pengeluaran): View
    {
        $this->authorize('update', $pengeluaran);

        $jenis_pengeluarans = JenisPengeluaran::all();

        return view('transaksi.pengeluaran.edit', compact('pengeluaran', 'jenis_pengeluarans'));
    }


    public function update(
        PengeluaranUpdateRequest $request,
        Pengeluaran $pengeluaran
    ): RedirectResponse {
        $this->authorize('update', $pengeluaran);

        $validated = $request->validated();

        $pengeluaran->update($validated);

        return redirect()
            ->route('pengeluaran.edit', $pengeluaran)
            ->withSuccess(__('crud.common.saved'));
    }


    public function destroy(
        Request $request,
        Pengeluaran $pengeluaran
    ): RedirectResponse {
        $this->authorize('delete', $pengeluaran);

        $pengeluaran->delete();

        return redirect()
            ->route('pengeluaran.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Pengeluaran_Export_Excel, 'Pengeluaran - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $pengeluarans = Pengeluaran::all();

        $pdf = PDF::loadView('PDF.pengeluaran', compact('pengeluarans'))->setPaper('a4', 'potrait');;

        return $pdf->download('Pengeluaran - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
