<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\UkuranProduk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UkuranProdukStoreRequest;
use App\Http\Requests\UkuranProdukUpdateRequest;
use App\Exports\UkuranProduk_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UkuranProdukController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', UkuranProduk::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $ukuran_produks = UkuranProduk::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('produk', function ($query) use ($search) {
                    $query->where('nama_produk', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.ukuran_produk.index', compact('ukuran_produks', 'search', 'sortBy', 'sortDirection'));
    }

    
    public function create(Request $request): View
    {
        $this->authorize('create', UkuranProduk::class);

        $produks = Produk::pluck('nama_produk', 'id');

        return view('masterdata.ukuran_produk.create', compact('produks'));
    }


    public function store(UkuranProdukStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', UkuranProduk::class);

        $validated = $request->validated();

        $ukuran_produk = UkuranProduk::create($validated);

        return redirect()
            ->route('ukuran_produk.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, UkuranProduk $ukuran_produk): View
    {
        $this->authorize('view', $ukuran_produk);

        return view('masterdata.ukuran_produk.show', compact('ukuran_produk'));
    }


    public function edit(Request $request, UkuranProduk $ukuran_produk): View
    {
        $this->authorize('update', $ukuran_produk);

        $produks = Produk::pluck('nama_produk', 'id');

        return view('masterdata.ukuran_produk.edit', compact('ukuran_produk', 'produks'));
    }


    public function update(
        UkuranProdukUpdateRequest $request,
        UkuranProduk $ukuran_produk
    ): RedirectResponse {
        $this->authorize('update', $ukuran_produk);

        $validated = $request->validated();

        $ukuran_produk->update($validated);

        return redirect()
            ->route('ukuran_produk.edit', $ukuran_produk)
            ->withSuccess(__('crud.common.saved'));
    }


    public function destroy(
        Request $request,
        UkuranProduk $ukuran_produk
    ): RedirectResponse {
        $this->authorize('delete', $ukuran_produk);
        
        $ukuran_produk->delete();

        return redirect()
            ->route('ukuran_produk.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new UkuranProduk_Export_Excel, 'Ukuran Produk - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $ukuran_produks = UkuranProduk::all();

        $pdf = PDF::loadView('PDF.ukuran_produk', compact('ukuran_produks'))->setPaper('a4', 'landscape');;

        return $pdf->download('Ukuran Produk - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
