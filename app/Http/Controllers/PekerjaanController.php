<?php

namespace App\Http\Controllers;

use App\Models\Pekerjaan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PekerjaanStoreRequest;
use App\Http\Requests\PekerjaanUpdateRequest;
use App\Exports\Pekerjaans_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Pekerjaan::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $pekerjaans = Pekerjaan::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_pekerjaan', 'LIKE', "%{$search}%")
                    ->orWhere('gaji_per_pekerjaan', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.pekerjaans.index', compact('pekerjaans', 'search', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Pekerjaan::class);

        return view('masterdata.pekerjaans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PekerjaanStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Pekerjaan::class);

        $validated = $request->validated();

        $pekerjaan = Pekerjaan::create($validated);

        return redirect()
            ->route('pekerjaans.index')
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Pekerjaan $pekerjaan): View
    {
        $this->authorize('view', $pekerjaan);

        return view('masterdata.pekerjaans.show', compact('pekerjaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Pekerjaan $pekerjaan): View
    {
        $this->authorize('update', $pekerjaan);

        return view('masterdata.pekerjaans.edit', compact('pekerjaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PekerjaanUpdateRequest $request,
        Pekerjaan $pekerjaan
    ): RedirectResponse {
        $this->authorize('update', $pekerjaan);

        $validated = $request->validated();

        $pekerjaan->update($validated);

        return redirect()
            ->route('pekerjaans.edit', $pekerjaan)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Pekerjaan $pekerjaan
    ): RedirectResponse {
        $this->authorize('delete', $pekerjaan);
        $pekerjaan->delete();

        return redirect()
            ->route('pekerjaans.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Pekerjaans_Export_Excel, 'Pekerjaans - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $pekerjaans = Pekerjaan::all();

        $pdf = PDF::loadView('PDF.pekerjaans', compact('pekerjaans'))->setPaper('a4', 'landscape');;

        return $pdf->download('Pekerjaans - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
