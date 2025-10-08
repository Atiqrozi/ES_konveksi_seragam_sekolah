<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProdukStoreRequest;
use App\Http\Requests\ProdukUpdateRequest;
use App\Exports\Produks_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ProdukController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Produk::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $produks = Produk::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_produk', 'LIKE', "%{$search}%");
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('kategori', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.produks.index', compact('produks', 'search', 'sortBy', 'sortDirection'));
    }


    public function create(Request $request): View
    {
        $this->authorize('create', Produk::class);

        $kategoris = Kategori::pluck('nama', 'id');

        return view('masterdata.produks.create', compact('kategoris'));
    }


    public function store(ProdukStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Produk::class);

        $validated = $request->validated();

        if ($request->hasFile('foto_sampul')) {
            $validated['foto_sampul'] = $request->file('foto_sampul')->store('public/produk');
        } else {
            return back()->withErrors(['foto_sampul' => 'Gambar sampul wajib diunggah'])->withInput();
        }

        $optionalFields = ['foto_lain_1', 'foto_lain_2', 'foto_lain_3', 'video'];

        foreach ($optionalFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('public/produk');
            }
        }

        $produk = Produk::create($validated);

        return redirect()
            ->route('produks.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, Produk $produk): View
    {
        $this->authorize('view', $produk);

        return view('masterdata.produks.show', compact('produk'));
    }


    public function edit(Request $request, Produk $produk): View
    {
        $this->authorize('update', $produk);

        $kategoris = Kategori::pluck('nama', 'id');

        return view('masterdata.produks.edit', compact('produk', 'kategoris'));
    }


    public function update(ProdukUpdateRequest $request, Produk $produk): RedirectResponse
    {
        $this->authorize('update', $produk);

        $validated = $request->validated();

        // Update foto_sampul jika ada upload baru
        if ($request->hasFile('foto_sampul')) {
            if ($produk->foto_sampul) {
                Storage::delete($produk->foto_sampul);
            }
            $validated['foto_sampul'] = $request->file('foto_sampul')->store('public/produk');
        }

        // Field opsional
        $optionalFields = ['foto_lain_1', 'foto_lain_2', 'foto_lain_3', 'video'];

        foreach ($optionalFields as $field) {
            if ($request->hasFile($field)) {
                if ($produk->$field) {
                    Storage::delete($produk->$field);
                }
                $validated[$field] = $request->file($field)->store('public/produk');
            }
        }

        $produk->update($validated);

        return redirect()
            ->route('produks.edit', $produk)
            ->withSuccess(__('crud.common.saved'));
    }


    public function destroy(Request $request, Produk $produk): RedirectResponse
    {
        $this->authorize('delete', $produk);

        // Semua field file yang perlu dihapus
        $fileFields = ['foto_sampul', 'foto_lain_1', 'foto_lain_2', 'foto_lain_3', 'video'];

        foreach ($fileFields as $field) {
            if (!empty($produk->$field) && Storage::exists($produk->$field)) {
                Storage::delete($produk->$field);
            }
        }

        $produk->delete();

        return redirect()
            ->route('produks.index')
            ->withSuccess(__('crud.common.removed'));
    }


    public function export_excel()
    {
        return Excel::download(new Produks_Export_Excel, 'Produks - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $produks = Produk::all();

        $pdf = PDF::loadView('PDF.produks', compact('produks'))->setPaper('a4', 'landscape');;

        return $pdf->download('Produks - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
