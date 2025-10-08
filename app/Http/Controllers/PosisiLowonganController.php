<?php

namespace App\Http\Controllers;

use App\Models\PosisiLowongan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PosisiLowonganStoreRequest;
use App\Http\Requests\PosisiLowonganUpdateRequest;
use App\Exports\PosisiLowongan_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PosisiLowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', PosisiLowongan::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $posisi_lowongans = PosisiLowongan::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_posisi', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('hiring.posisi_lowongan.index', compact('posisi_lowongans', 'search', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', PosisiLowongan::class);

        return view('hiring.posisi_lowongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PosisiLowonganStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', PosisiLowongan::class);

        $validated = $request->validated();

        $posisi_lowongan = PosisiLowongan::create($validated);

        return redirect()
            ->route('posisi_lowongan.index')
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, PosisiLowongan $posisi_lowongan): View
    {
        $this->authorize('view', $posisi_lowongan);

        return view('hiring.posisi_lowongan.show', compact('posisi_lowongan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PosisiLowongan $posisi_lowongan): View
    {
        $this->authorize('update', $posisi_lowongan);

        return view('hiring.posisi_lowongan.edit', compact('posisi_lowongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PosisiLowonganUpdateRequest $request,
        PosisiLowongan $posisi_lowongan
    ): RedirectResponse {
        $this->authorize('update', $posisi_lowongan);

        $validated = $request->validated();

        $posisi_lowongan->update($validated);

        return redirect()
            ->route('posisi_lowongan.edit', $posisi_lowongan)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        PosisiLowongan $posisi_lowongan
    ): RedirectResponse {
        $this->authorize('delete', $posisi_lowongan);
        $posisi_lowongan->delete();

        return redirect()
            ->route('posisi_lowongan.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new PosisiLowongan_Export_Excel, 'Posisi Lowongan - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $posisi_lowongans = PosisiLowongan::all();

        $pdf = PDF::loadView('PDF.posisi_lowongan', compact('posisi_lowongans'))->setPaper('a4', 'landscape');;

        return $pdf->download('Posisi Lowongan - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
