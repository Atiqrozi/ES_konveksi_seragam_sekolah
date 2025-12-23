<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStokProduk;
use App\Models\StokProduk;
use App\Models\StokKeluar;
use App\Models\Produk;
use App\Models\UkuranProduk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
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

        // Query untuk stok_produk (data terkini tanpa duplikat)
        $riwayat_stok_produks = StokProduk::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('produk', function ($query) use ($search) {
                    $query->where('nama_produk', 'LIKE', "%{$search}%");
                });
            })
            ->with(['produk'])
            ->leftJoin('produks', 'stok_produk.produk_id', '=', 'produks.id')
            ->orderBy($sortBy === 'nama_produk' ? 'produks.nama_produk' : "stok_produk.$sortBy", $sortDirection)
            ->select('stok_produk.*')
            ->paginate($paginate)
            ->withQueryString();

        // Statistik dari stok_produk (data terkini yang akurat)
        // Total stok tersedia saat ini
        $total_stok_masuk = StokProduk::sum('stok_tersedia');
        
        // Total stok keluar = Dari tabel stok_keluar
        $total_stok_keluar = StokKeluar::sum('jumlah_keluar');
        
        // Total transaksi = Jumlah item produk unik
        $total_transaksi = StokProduk::count();

        return view('transaksi.riwayat_stok_produk.index', compact(
            'riwayat_stok_produks', 
            'search', 
            'sortBy', 
            'sortDirection',
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
            $jumlah_perubahan = $request->stok_masuk;
        } else {
            $validated['tipe_transaksi'] = 'keluar';
            $validated['stok_masuk'] = 0;
            $jumlah_perubahan = $request->stok_keluar;
        }

        // Gunakan database transaction untuk memastikan konsistensi data
        DB::beginTransaction();
        try {
            // 1. Insert ke riwayat_stok_produk (history)
            $riwayat_stok_produk = RiwayatStokProduk::create($validated);

            // 2. Update atau create stok_produk (current stock)
            $stok_produk = StokProduk::where('produk_id', $request->id_produk)
                ->where('ukuran_produk', $request->ukuran_produk)
                ->first();

            if ($stok_produk) {
                // Update stok yang sudah ada
                if ($validated['tipe_transaksi'] === 'masuk') {
                    $newValue = $stok_produk->stok_tersedia + $jumlah_perubahan;
                } else {
                    $newValue = $stok_produk->stok_tersedia - $jumlah_perubahan;
                    if ($newValue < 0) {
                        DB::rollBack();
                        return redirect()
                            ->back()
                            ->withErrors(['stok_keluar' => 'Stok tidak mencukupi! Stok tersedia: ' . $stok_produk->stok_tersedia])
                            ->withInput();
                    }
                }
                $stok_produk->update(['stok_tersedia' => $newValue]);
            } else {
                // Buat stok baru
                if ($validated['tipe_transaksi'] === 'keluar') {
                    DB::rollBack();
                    return redirect()
                        ->back()
                        ->withErrors(['stok_keluar' => 'Stok tidak ditemukan! Tidak dapat melakukan stok keluar.'])
                        ->withInput();
                }
                
                StokProduk::create([
                    'produk_id' => $request->id_produk,
                    'ukuran_produk' => $request->ukuran_produk,
                    'stok_tersedia' => $jumlah_perubahan,
                ]);
            }

            // 3. Update stok di tabel ukuran_produk (untuk compatibility dengan sistem lama)
            $ukuran_produk = UkuranProduk::where('produk_id', $request->id_produk)
                ->where('ukuran', $request->ukuran_produk)
                ->first();

            if ($ukuran_produk) {
                if ($validated['tipe_transaksi'] === 'masuk') {
                    $ukuran_produk->update(['stok' => $ukuran_produk->stok + $jumlah_perubahan]);
                } else {
                    $ukuran_produk->update(['stok' => $ukuran_produk->stok - $jumlah_perubahan]);
                }
            }

            DB::commit();

            return redirect()
                ->route('riwayat_stok_produk.index')
                ->withSuccess(__('crud.common.created'));
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function show(Request $request, RiwayatStokProduk $riwayat_stok_produk): View
    {
        $this->authorize('view', $riwayat_stok_produk);

        return view('transaksi.riwayat_stok_produk.show', compact('riwayat_stok_produk'));
    }

    public function history(Request $request)
    {
        $this->authorize('view-any', RiwayatStokProduk::class);

        $produk_id = $request->get('produk_id');
        $ukuran = $request->get('ukuran');
        
        // Get stok terkini
        $stok_produk = StokProduk::with('produk')
            ->where('produk_id', $produk_id)
            ->where('ukuran_produk', $ukuran)
            ->firstOrFail();
        
        // Get history transaksi
        $histories = RiwayatStokProduk::with(['produk', 'user'])
            ->where('id_produk', $produk_id)
            ->where('ukuran_produk', $ukuran)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('transaksi.riwayat_stok_produk.history', compact('stok_produk', 'histories'));
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

    public function stok_keluar(Request $request)
    {
        $this->authorize('view-any', RiwayatStokProduk::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Query untuk stok keluar dari tabel stok_keluar
        $riwayat_stok_produks = StokKeluar::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('produk', function ($query) use ($search) {
                    $query->where('nama_produk', 'LIKE', "%{$search}%");
                });
            })
            ->with(['produk', 'user'])
            ->leftJoin('produks', 'stok_keluar.produk_id', '=', 'produks.id')
            ->orderBy($sortBy === 'nama_produk' ? 'produks.nama_produk' : "stok_keluar.$sortBy", $sortDirection)
            ->select('stok_keluar.*')
            ->paginate($paginate)
            ->withQueryString();

        // Statistik
        $total_stok_masuk = StokProduk::sum('stok_tersedia');
        $total_stok_keluar = StokKeluar::sum('jumlah_keluar');
        $total_transaksi = StokProduk::count();

        return view('transaksi.riwayat_stok_produk.stok_keluar', compact(
            'riwayat_stok_produks', 
            'search', 
            'sortBy', 
            'sortDirection',
            'total_stok_masuk',
            'total_stok_keluar',
            'total_transaksi'
        ));
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
