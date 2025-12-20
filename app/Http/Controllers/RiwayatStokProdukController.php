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
        $tipe_transaksi = $request->get('tipe_transaksi', '');

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
            ->when($tipe_transaksi, function ($query, $tipe_transaksi) {
                return $query->where('tipe_transaksi', $tipe_transaksi);
            })
            ->with(['produk', 'user'])
            ->leftJoin('produks', 'riwayat_stok_produks.id_produk', '=', 'produks.id')
            ->orderBy($sortBy === 'nama_produk' ? 'produks.nama_produk' : "riwayat_stok_produks.$sortBy", $sortDirection)
            ->select('riwayat_stok_produks.*')
            ->paginate($paginate)
            ->withQueryString();

        // Statistik
        $total_stok_masuk = RiwayatStokProduk::where('tipe_transaksi', 'masuk')->sum('stok_masuk');
        $total_stok_keluar = RiwayatStokProduk::where('tipe_transaksi', 'keluar')->sum('stok_keluar');
        $total_transaksi = RiwayatStokProduk::count();

        return view('transaksi.riwayat_stok_produk.index', compact(
            'riwayat_stok_produks', 
            'search', 
            'sortBy', 
            'sortDirection', 
            'start_date', 
            'end_date',
            'tipe_transaksi',
            'total_stok_masuk',
            'total_stok_keluar',
            'total_transaksi'
        ));
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
        $validated['user_id'] = auth()->id();

        // Tentukan tipe transaksi
        if ($request->stok_masuk > 0) {
            $validated['tipe_transaksi'] = 'masuk';
            $validated['stok_keluar'] = 0;
        } else {
            $validated['tipe_transaksi'] = 'keluar';
            $validated['stok_masuk'] = 0;
        }

        $riwayat_stok_produk = RiwayatStokProduk::create($validated);

        $stok_produk = UkuranProduk::where('produk_id', $request->id_produk)
            ->where('ukuran', $request->ukuran_produk)
            ->first();

        if ($validated['tipe_transaksi'] === 'masuk') {
            $newValue = $stok_produk->stok + $request->stok_masuk;
        } else {
            $newValue = $stok_produk->stok - $request->stok_keluar;
            if ($newValue < 0) {
                return redirect()
                    ->back()
                    ->withErrors(['stok_keluar' => 'Stok tidak mencukupi! Stok tersedia: ' . $stok_produk->stok])
                    ->withInput();
            }
        }

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

    public function edit(Request $request, RiwayatStokProduk $riwayat_stok_produk): View
    {
        $this->authorize('update', $riwayat_stok_produk);

        // Only allow editing for manual stock entries (masuk)
        if ($riwayat_stok_produk->tipe_transaksi !== 'masuk') {
            abort(403, 'Hanya stok masuk yang dapat diedit.');
        }

        $produks = Produk::pluck('nama_produk', 'id');
        $ukuranProduks = UkuranProduk::all()->groupBy('produk_id');

        return view('transaksi.riwayat_stok_produk.edit', compact('riwayat_stok_produk', 'produks', 'ukuranProduks'));
    }

    public function update(RiwayatStokProdukStoreRequest $request, RiwayatStokProduk $riwayat_stok_produk): RedirectResponse
    {
        $this->authorize('update', $riwayat_stok_produk);

        // Only allow updating for manual stock entries (masuk)
        if ($riwayat_stok_produk->tipe_transaksi !== 'masuk') {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Hanya stok masuk yang dapat diedit.']);
        }

        $validated = $request->validated();
        
        // Find the stock record
        $stok_produk = UkuranProduk::where('produk_id', $request->id_produk)
            ->where('ukuran', $request->ukuran_produk)
            ->first();

        // Reverse the old stock entry
        $stok_produk->stok -= $riwayat_stok_produk->stok_masuk;

        // Apply the new stock entry
        $stok_produk->stok += $request->stok_masuk;
        $stok_produk->save();

        // Update the record
        $validated['tipe_transaksi'] = 'masuk';
        $validated['stok_keluar'] = 0;
        $validated['user_id'] = auth()->id();
        
        $riwayat_stok_produk->update($validated);

        return redirect()
            ->route('riwayat_stok_produk.index')
            ->withSuccess(__('crud.common.updated'));
    }

    public function destroy(Request $request, RiwayatStokProduk $riwayat_stok_produk): RedirectResponse
    {
        $this->authorize('delete', $riwayat_stok_produk);

        // Only allow deleting for manual stock entries (masuk)
        if ($riwayat_stok_produk->tipe_transaksi !== 'masuk') {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Hanya stok masuk yang dapat dihapus.']);
        }

        // Find the stock record and reverse the entry
        $stok_produk = UkuranProduk::where('produk_id', $riwayat_stok_produk->id_produk)
            ->where('ukuran', $riwayat_stok_produk->ukuran_produk)
            ->first();

        if ($stok_produk) {
            $stok_produk->stok -= $riwayat_stok_produk->stok_masuk;
            
            // Prevent negative stock
            if ($stok_produk->stok < 0) {
                return redirect()
                    ->back()
                    ->withErrors(['error' => 'Tidak dapat menghapus karena akan menyebabkan stok negatif.']);
            }
            
            $stok_produk->save();
        }

        $riwayat_stok_produk->delete();

        return redirect()
            ->route('riwayat_stok_produk.index')
            ->withSuccess(__('crud.common.removed'));
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
