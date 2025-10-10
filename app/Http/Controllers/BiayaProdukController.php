<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Komponen;
use App\Models\ProdukKomponen;
use App\Models\BiayaProduk;
use App\Models\UkuranProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BiayaProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produks = Produk::with(['kategori', 'produkKomponens.komponen', 'biayaProduk'])
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
        $komponens = Komponen::all();
        return view('master-data.biaya-produk.create', compact('produks', 'komponens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log request data
        Log::info('BiayaProduk Store Request Data:', $request->all());

        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produks,id',
            'komponen_ids' => 'nullable|array',
            'komponen_ids.*' => 'exists:komponens,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'numeric|min:0.01'
        ]);

        if ($validator->fails()) {
            Log::error('BiayaProduk Validation Failed:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data tidak valid!');
        }

        try {
            DB::beginTransaction();

            $produk = Produk::findOrFail($request->produk_id);
            $totalBiayaKomponen = 0;

            // Jika ada komponen yang ditambahkan
            if ($request->komponen_ids && $request->quantities) {
                // Definisi ukuran dan multiplier
                $ukuranMultipliers = [
                    'S' => 1.0,
                    'M' => 1.3,
                    'L' => 1.6,
                    'XL' => 1.9,
                    'XXL' => 2.2,
                    'JUMBO' => 2.5
                ];

                foreach ($request->komponen_ids as $index => $komponen_id) {
                    if (isset($request->quantities[$index]) && $request->quantities[$index] > 0) {
                        // Ambil harga komponen saat ini
                        $komponen = Komponen::findOrFail($komponen_id);
                        $quantity = $request->quantities[$index];
                        $harga_per_unit = $komponen->harga;

                        Log::info('Processing komponen:', [
                            'index' => $index,
                            'komponen_id' => $komponen_id,
                            'komponen_nama' => $komponen->nama_komponen,
                            'quantity' => $quantity,
                            'harga_per_unit' => $harga_per_unit
                        ]);

                        // Simpan untuk setiap ukuran
                        foreach ($ukuranMultipliers as $ukuran => $multiplier) {
                            // Cek apakah kombinasi sudah ada
                            $existing = ProdukKomponen::where([
                                'produk_id' => $produk->id,
                                'komponen_id' => $komponen_id,
                                'ukuran' => $ukuran
                            ])->first();

                            if (!$existing) {
                                $total_harga = $quantity * $harga_per_unit * $multiplier;

                                $created = ProdukKomponen::create([
                                    'produk_id' => $produk->id,
                                    'komponen_id' => $komponen_id,
                                    'ukuran' => $ukuran,
                                    'quantity' => $quantity,
                                    'harga_per_unit' => $harga_per_unit,
                                    'total_harga' => $total_harga
                                ]);

                                Log::info('Created ProdukKomponen:', [
                                    'id' => $created->id,
                                    'produk_id' => $produk->id,
                                    'komponen_id' => $komponen_id,
                                    'ukuran' => $ukuran,
                                    'quantity' => $quantity,
                                    'total_harga' => $total_harga
                                ]);

                                // Hanya tambahkan ke total biaya untuk ukuran S (base calculation)
                                if ($ukuran === 'S') {
                                    $totalBiayaKomponen += $total_harga;
                                }
                            } else {
                                Log::info('ProdukKomponen already exists:', [
                                    'produk_id' => $produk->id,
                                    'komponen_id' => $komponen_id,
                                    'ukuran' => $ukuran,
                                    'existing_id' => $existing->id
                                ]);
                            }
                        }
                    }
                }
            }

            // Buat atau update BiayaProduk
            $biayaProduk = BiayaProduk::updateOrCreate(
                ['produk_id' => $produk->id],
                [
                    'total_biaya_komponen' => $totalBiayaKomponen,
                    'keterangan' => $request->keterangan
                ]
            );

            Log::info('Created/Updated BiayaProduk:', [
                'id' => $biayaProduk->id,
                'produk_id' => $produk->id,
                'total_biaya_komponen' => $totalBiayaKomponen,
                'keterangan' => $request->keterangan
            ]);

            // Update total biaya dari semua komponen yang ada
            $biayaProduk->updateTotalBiaya();
            
            // Hitung dan update semua tipe harga
            $biayaProduk->updateAllTipeHarga();
            
            // Sinkronisasi ke UkuranProduk
            $this->syncToUkuranProduk($produk);
            
            Log::info('After updateTotalBiaya and updateAllTipeHarga:', [
                'total_biaya_komponen' => $biayaProduk->total_biaya_komponen,
                'harga_s_1' => $biayaProduk->harga_s_1,
                'harga_s_2' => $biayaProduk->harga_s_2,
                'harga_s_3' => $biayaProduk->harga_s_3,
                'harga_s_4' => $biayaProduk->harga_s_4
            ]);

            DB::commit();
            
            // Debug: Log what was saved
            try {
                $savedComponents = ProdukKomponen::where('produk_id', $produk->id)->get();
                Log::info('Saved ProdukKomponen count:', ['count' => $savedComponents->count()]);
                
                if ($savedComponents->count() > 0) {
                    Log::info('First few saved components:', $savedComponents->take(3)->toArray());
                }
                
                $savedBiayaProduk = BiayaProduk::where('produk_id', $produk->id)->first();
                if ($savedBiayaProduk) {
                    Log::info('Saved BiayaProduk:', $savedBiayaProduk->toArray());
                    
                    // Redirect ke edit jika BiayaProduk berhasil dibuat
                    return redirect()->route('biaya-produk.edit', $savedBiayaProduk->total_biaya_komponen)->with('success', 'Berhasil! Data biaya produk telah disimpan. Total komponen tersimpan: ' . $savedComponents->count() . '. Anda dapat mengelola komponen di halaman ini.');
                } else {
                    Log::info('BiayaProduk not found for produk_id:', ['produk_id' => $produk->id]);
                    // Jika tidak ditemukan, redirect ke index
                    return redirect()->route('biaya-produk.index')->with('success', 'Data komponen berhasil disimpan (Total: ' . $savedComponents->count() . '), namun terjadi masalah saat membuat biaya produk. Silakan coba lagi.');
                }
                
            } catch (\Exception $e) {
                Log::error('Error checking saved data:', ['error' => $e->getMessage()]);
                // Jika ada error, redirect ke index untuk keamanan
                return redirect()->route('biaya-produk.index')->with('success', 'Data mungkin sudah tersimpan, namun terjadi error saat verifikasi. Silakan cek di daftar biaya produk.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('BiayaProduk Store Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($total_harga)
    {
        // Cari BiayaProduk berdasarkan total_harga atau ID
        $biayaProduk = BiayaProduk::where('total_biaya_komponen', $total_harga)
                                  ->orWhere('id', $total_harga)
                                  ->first();
        
        if (!$biayaProduk) {
            // Jika tidak ditemukan, coba cari berdasarkan produk_id
            $produk = Produk::find($total_harga);
            if (!$produk) {
                abort(404, 'Data tidak ditemukan');
            }
            $biayaProduk = $produk->biayaProduk;
        } else {
            $produk = $biayaProduk->produk;
        }
        
        $produk->load(['kategori', 'produkKomponens.komponen', 'biayaProduk']);
        return view('master-data.biaya-produk.show', compact('produk', 'biayaProduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($total_harga)
    {
        // Cari BiayaProduk berdasarkan total_harga atau ID
        $biayaProduk = BiayaProduk::where('total_biaya_komponen', $total_harga)
                                  ->orWhere('id', $total_harga)
                                  ->firstOrFail();
        
        $produk = $biayaProduk->produk;
        $produk->load(['produkKomponens.komponen']);
        $komponens = Komponen::all();
        
        return view('master-data.biaya-produk.edit', compact('produk', 'komponens', 'biayaProduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $total_harga)
    {
        // Cari BiayaProduk berdasarkan total_harga atau ID
        $biayaProduk = BiayaProduk::where('total_biaya_komponen', $total_harga)
                                  ->orWhere('id', $total_harga)
                                  ->firstOrFail();
        
        $produk = $biayaProduk->produk;
        $validator = Validator::make($request->all(), [
            'komponen_ids' => 'nullable|array',
            'komponen_ids.*' => 'exists:komponens,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'numeric|min:0.01',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data tidak valid!');
        }

        try {
            DB::beginTransaction();

            // Update keterangan produk jika ada
            if ($request->has('keterangan')) {
                $produk->update(['keterangan' => $request->keterangan]);
            }

            // Jika ada komponen yang ditambahkan
            if ($request->komponen_ids && $request->quantities) {
                foreach ($request->komponen_ids as $index => $komponen_id) {
                    if (isset($request->quantities[$index]) && $request->quantities[$index] > 0) {
                        // Cek apakah kombinasi sudah ada
                        $existing = ProdukKomponen::where([
                            'produk_id' => $produk->id,
                            'komponen_id' => $komponen_id
                        ])->first();

                        if ($existing) {
                            // Update quantity jika sudah ada
                            $existing->update(['quantity' => $request->quantities[$index]]);
                        } else {
                            // Buat baru jika belum ada
                            ProdukKomponen::create([
                                'produk_id' => $produk->id,
                                'komponen_id' => $komponen_id,
                                'quantity' => $request->quantities[$index]
                            ]);
                        }
                    }
                }
            }

            // Update total biaya dan tipe harga
            $biayaProduk->updateTotalBiaya();
            $biayaProduk->updateAllTipeHarga();
            
            // Sinkronisasi ke UkuranProduk
            $this->syncToUkuranProduk($produk);

            DB::commit();
            return redirect()->back()->with('success', 'Komponen berhasil diperbarui dan harga telah dihitung ulang!');
        } catch (\Exception $e) {
            DB::rollback();
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

    /**
     * Sinkronisasi harga dari BiayaProduk ke UkuranProduk
     */
    private function syncToUkuranProduk(Produk $produk)
    {
        $ukuranMultipliers = [
            'S' => 1.0,
            'M' => 1.3, 
            'L' => 1.6,
            'XL' => 1.9,
            'XXL' => 2.2,
            'JUMBO' => 2.5
        ];
        
        foreach ($ukuranMultipliers as $ukuran => $multiplier) {
            // Hitung harga berdasarkan komponen untuk ukuran ini
            $hargaKomponen = $produk->getTotalBiayaForUkuran($ukuran);
            
            if ($hargaKomponen > 0) {
                // Cari atau buat UkuranProduk
                UkuranProduk::updateOrCreate(
                    [
                        'produk_id' => $produk->id,
                        'ukuran' => $ukuran
                    ],
                    [
                        'stok' => 100, // default stock
                        'harga_produk_1' => $hargaKomponen,           // Harga asli dari komponen
                        'harga_produk_2' => $hargaKomponen * 1.10,   // +10%
                        'harga_produk_3' => $hargaKomponen * 1.20,   // +20%
                        'harga_produk_4' => $hargaKomponen * 1.30,   // +30%
                    ]
                );
            }
        }
        
        Log::info('Sinkronisasi UkuranProduk completed for produk: ' . $produk->nama_produk);
    }
}