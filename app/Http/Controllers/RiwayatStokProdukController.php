<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStokProduk;
use App\Models\Produk;
use App\Models\UkuranProduk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RiwayatStokProdukStoreRequest;
use App\Exports\RiwayatStokProduk_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\StokMasuk\StokMasukChart;

class RiwayatStokProdukController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-any', RiwayatStokProduk::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');
        $start_date = $request->get('start_date', '');
        $end_date = $request->get('end_date', '');

        // Pastikan tanggal kedua tidak lebih kecil dari tanggal pertama
        if ($start_date && $end_date && $start_date > $end_date) {
            return redirect()->back()->withErrors(['end_date' => 'Tanggal selesai tidak boleh lebih kecil dari tanggal mulai.']);
        }

        $riwayat_stok_produks = RiwayatStokProduk::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('produk', function ($query) use ($search) {
                    $query->where('nama_produk', 'LIKE', "%{$search}%");
                });
            })
            ->when($start_date, function ($query, $start_date) {
                return $query->whereDate('riwayat_stok_produks.created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query, $end_date) {
                return $query->whereDate('riwayat_stok_produks.created_at', '<=', $end_date);
            })
            ->with('produk')
            ->leftJoin('produks', 'riwayat_stok_produks.id_produk', '=', 'produks.id')
            ->orderBy($sortBy === 'nama_produk' ? 'produks.nama_produk' : "riwayat_stok_produks.$sortBy", $sortDirection)
            ->select('riwayat_stok_produks.*')
            ->paginate($paginate)
            ->withQueryString();

        return view('transaksi.riwayat_stok_produk.index', compact('riwayat_stok_produks', 'search', 'sortBy', 'sortDirection', 'start_date', 'end_date'));
    }



    public function create(Request $request): View
    {
        $this->authorize('create', RiwayatStokProduk::class);

        $produks = Produk::pluck('nama_produk', 'id');
        $ukuranProduks = UkuranProduk::all()->groupBy('produk_id');

        return view('transaksi.riwayat_stok_produk.create', compact('produks', 'ukuranProduks'));
    }

  
    public function store(RiwayatStokProdukStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', RiwayatStokProduk::class);

        $validated = $request->validated();

        $riwayat_stok_produk = RiwayatStokProduk::create($validated);

        $stok_produk = UkuranProduk::where('produk_id', $request->id_produk)
            ->where('ukuran', $request->ukuran_produk)
            ->first();

        $newValue = $stok_produk->stok + $request->stok_masuk;
        $stok_produk->update(['stok' => $newValue]);

        return redirect()
            ->route('riwayat_stok_produk.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, RiwayatStokProduk $riwayat_stok_produk): View
    {
        $this->authorize('view', $riwayat_stok_produk);

        return view('transaksi.riwayat_stok_produk.show', compact('riwayat_stok_produk'));
    }

    public function export_excel()
    {
        return Excel::download(new RiwayatStokProduk_Export_Excel, 'Riwayat Stok Produk - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $riwayat_stok_produks = RiwayatStokProduk::all();

        $pdf = PDF::loadView('PDF.riwayat_stok_produk', compact('riwayat_stok_produks'))->setPaper('a4', 'landscape');;

        return $pdf->download('Riwayat Stok Produk - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
