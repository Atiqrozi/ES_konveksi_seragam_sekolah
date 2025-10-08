<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ArtikelStoreRequest;
use App\Http\Requests\ArtikelUpdateRequest;
use App\Exports\Artikel_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Artikel::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $artikels = Artikel::query()
            ->when($search, function ($query, $search) {
                return $query->where('judul', 'LIKE', "%{$search}%")
                    ->orWhere('penulis', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.artikel.index', compact('artikels', 'search', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Artikel::class);

        return view('masterdata.artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArtikelStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Artikel::class);

        $validated = $request->validated();

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('public/artikel_cover');
        }

        $artikel = Artikel::create($validated);

        return redirect()
            ->route('artikels.index')
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Artikel $artikel): View
    {
        $this->authorize('view', $artikel);

        return view('masterdata.artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Artikel $artikel): View
    {
        $this->authorize('update', $artikel);

        return view('masterdata.artikel.edit', compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ArtikelUpdateRequest $request,
        Artikel $artikel
    ): RedirectResponse {
        $this->authorize('update', $artikel);

        $validated = $request->validated();

        if ($request->hasFile('cover')) {
            if ($artikel->cover) {
                Storage::delete($artikel->cover);
            }

            $validated['cover'] = $request->file('cover')->store('public/artikel_cover');
        }

        $artikel->update($validated);

        return redirect()
            ->route('artikels.edit', $artikel)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Artikel $artikel
    ): RedirectResponse {
        $this->authorize('delete', $artikel);

        if ($artikel->cover) {
            Storage::delete($artikel->cover);
        }

        $artikel->delete();
    
        return redirect()
            ->route('artikels.index')
            ->withSuccess(__('crud.common.removed'));
    }    

    public function export_excel()
    {
        return Excel::download(new Artikel_Export_Excel, 'Artikel - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $artikels = Artikel::all();

        $pdf = PDF::loadView('PDF.artikel', compact('artikels'))->setPaper('a4', 'potrait');;

        return $pdf->download('Artikel - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
