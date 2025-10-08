<?php

namespace App\Http\Controllers;

use App\Models\Komponen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KomponenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $komponens = Komponen::when($request->search, function ($query, $search) {
                            return $query->where('nama_komponen', 'like', "%{$search}%");
                        })
                        ->latest()
                        ->paginate(10);
        
        return view('master-data.komponen.index', compact('komponens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master-data.komponen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_komponen' => 'required|string|max:255|unique:komponens,nama_komponen',
            'harga' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data tidak valid!');
        }

        try {
            Komponen::create([
                'nama_komponen' => $request->nama_komponen,
                'harga' => $request->harga
            ]);

            return redirect()->route('komponen.index')->with('success', 'Komponen berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Komponen $komponen)
    {
        $komponen->load(['produks']);
        return view('master-data.komponen.show', compact('komponen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Komponen $komponen)
    {
        return view('master-data.komponen.edit', compact('komponen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Komponen $komponen)
    {
        $validator = Validator::make($request->all(), [
            'nama_komponen' => 'required|string|max:255|unique:komponens,nama_komponen,' . $komponen->id,
            'harga' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Data tidak valid!');
        }

        try {
            $komponen->update([
                'nama_komponen' => $request->nama_komponen,
                'harga' => $request->harga
            ]);

            return redirect()->route('komponen.index')->with('success', 'Komponen berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komponen $komponen)
    {
        try {
            // Cek apakah komponen sedang digunakan
            if ($komponen->produks()->count() > 0) {
                return redirect()->back()->with('error', 'Komponen tidak dapat dihapus karena sedang digunakan di ' . $komponen->produks()->count() . ' produk!');
            }

            $komponen->delete();
            return redirect()->route('komponen.index')->with('success', 'Komponen berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }

    /**
     * Toggle status komponen (jika diperlukan untuk fitur masa depan)
     */
    public function toggleStatus(Komponen $komponen)
    {
        try {
            $komponen->update([
                'is_active' => !$komponen->is_active
            ]);

            $status = $komponen->is_active ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->back()->with('success', "Komponen berhasil {$status}!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status!');
        }
    }
}