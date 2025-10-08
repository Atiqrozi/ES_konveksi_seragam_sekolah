<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Komponen;
use App\Models\ProdukKomponen;
use App\Models\UkuranProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BiayaProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produks = Produk::with(['kategori', 'produkKomponens.komponen'])
                        ->when($request->search, function ($query, $search) {
                            return $query->where('nama_produk', 'like', "%{$search}%");
                        })
                        ->paginate(10);

        return view('master-data.biaya-produk.index', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produks = Produk::with('kategori')->get();
        return view('master-data.biaya-produk.create', compact('produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produks,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data tidak valid!');
        }

        try {
            $produk = Produk::findOrFail($request->produk_id);
            return redirect()->route('biaya-produk.edit', $produk)->with('success', 'Berhasil! Sekarang Anda dapat mengelola komponen untuk produk: ' . $produk->nama_produk);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $produk->load(['kategori', 'produkKomponens.komponen']);
        return view('master-data.biaya-produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $produk->load(['produkKomponens.komponen']);
        $komponens = Komponen::all();
        return view('master-data.biaya-produk.edit', compact('produk', 'komponens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validator = Validator::make($request->all(), [
            'komponen_id' => 'required|exists:komponens,id',
            'ukuran' => 'required|in:S,M,L,XL,XXL,JUMBO',
            'quantity' => 'required|numeric|min:0.01'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data tidak valid!');
        }

        try {
            // Cek apakah kombinasi sudah ada
            $existing = ProdukKomponen::where([
                'produk_id' => $produk->id,
                'komponen_id' => $request->komponen_id,
                'ukuran' => $request->ukuran
            ])->first();

            if ($existing) {
                return redirect()->back()->withInput()->with('error', 'Komponen dengan ukuran ini sudah ada untuk produk ini!');
            }

            ProdukKomponen::create([
                'produk_id' => $produk->id,
                'komponen_id' => $request->komponen_id,
                'ukuran' => $request->ukuran,
                'quantity' => $request->quantity
            ]);

            return redirect()->back()->with('success', 'Komponen berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Remove komponen from produk
     */
    public function removeKomponen(Produk $produk, $komponenId)
    {
        try {
            $produkKomponen = ProdukKomponen::findOrFail($komponenId);
            $produkKomponen->delete();

            return redirect()->back()->with('success', 'Komponen berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }

    /**
     * Show form untuk mengelola komponen produk
     */
    public function manageKomponen($produkId)
    {
        $produk = Produk::with(['produkKomponens.komponen'])->findOrFail($produkId);
        $komponens = Komponen::all();
        $ukuranProduks = UkuranProduk::where('produk_id', $produkId)->get();

        return view('master-data.biaya-produk.manage-komponen', compact('produk', 'komponens', 'ukuranProduks'));
    }

    /**
     * Store komponen untuk produk
     */
    public function storeKomponen(Request $request, $produkId)
    {
        $validator = Validator::make($request->all(), [
            'komponen_id' => 'required|exists:komponens,id',
            'quantity' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data tidak valid!');
        }

        try {
            // Cek apakah kombinasi sudah ada
            $existing = ProdukKomponen::where([
                'produk_id' => $produkId,
                'komponen_id' => $request->komponen_id
            ])->first();

            if ($existing) {
                return redirect()->back()->withInput()->with('error', 'Komponen sudah ada untuk produk ini!');
            }

            ProdukKomponen::create([
                'produk_id' => $produkId,
                'komponen_id' => $request->komponen_id,
                'quantity' => $request->quantity
            ]);

            return redirect()->back()->with('success', 'Komponen berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Update komponen produk
     */
    public function updateKomponen(Request $request, $produkKomponenId)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data tidak valid!');
        }

        try {
            $produkKomponen = ProdukKomponen::findOrFail($produkKomponenId);
            $produkKomponen->update([
                'quantity' => $request->quantity
            ]);

            return redirect()->back()->with('success', 'Komponen berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data!');
        }
    }

    /**
     * Delete komponen produk
     */
    public function deleteKomponen($produkKomponenId)
    {
        try {
            $produkKomponen = ProdukKomponen::findOrFail($produkKomponenId);
            $produkKomponen->delete();

            return redirect()->back()->with('success', 'Komponen berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }

    /**
     * Update harga produk berdasarkan komponen
     */
    public function updateHargaFromKomponen($produkId)
    {
        try {
            $produk = Produk::findOrFail($produkId);
            $ukuranProduks = UkuranProduk::where('produk_id', $produkId)->get();

            foreach ($ukuranProduks as $ukuran) {
                $hargaKomponen = $produk->hitungHargaKomponen($ukuran->ukuran);
                
                $ukuran->update([
                    'harga_produk_1' => $hargaKomponen, // Harga asli
                    'harga_produk_2' => $hargaKomponen * 1.10, // +10%
                    'harga_produk_3' => $hargaKomponen * 1.10, // +10%
                    'harga_produk_4' => $hargaKomponen * 1.10, // +10%
                ]);
            }

            return redirect()->back()->with('success', 'Harga produk berhasil diperbarui berdasarkan komponen!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui harga!');
        }
    }
}