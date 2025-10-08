<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\KriteriaStoreRequest;
use App\Http\Requests\KriteriaUpdateRequest;
use App\Exports\Kriteria_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class KriteriaController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Kriteria::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $kriterias = Kriteria::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('bobot', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('hiring.kriteria.index', compact('kriterias', 'search', 'sortBy', 'sortDirection'));
    }

   
    public function create(Request $request): View
    {
        $this->authorize('create', Kriteria::class);

        return view('hiring.kriteria.create');
    }

    
    public function store(KriteriaStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Kriteria::class);

        $validated = $request->validated();

        $kriteria = Kriteria::create($validated);

        return redirect()
            ->route('kriteria.index')
            ->withSuccess(__('crud.common.created'));
    }

 
    public function show(Request $request, Kriteria $kriterium): View
    {
        $this->authorize('view', $kriterium);

        return view('hiring.kriteria.show', compact('kriterium'));
    }


    public function edit(Request $request, Kriteria $kriterium): View
    {
        $this->authorize('update', $kriterium);

        return view('hiring.kriteria.edit', compact('kriterium'));
    }

   
    public function update(
        KriteriaUpdateRequest $request,
        Kriteria $kriterium
    ): RedirectResponse {
        $this->authorize('update', $kriterium);

        $validated = $request->validated();

        $kriterium->update($validated);

        return redirect()
            ->route('kriteria.edit', $kriterium)
            ->withSuccess(__('crud.common.saved'));
    }

    
    public function destroy(
        Request $request,
        Kriteria $kriterium
    ): RedirectResponse {
        $this->authorize('delete', $kriterium);
        $kriterium->delete();

        return redirect()
            ->route('kriteria.index')
            ->withSuccess(__('crud.common.removed'));
    }


    public function export_excel()
    {
        return Excel::download(new Kriteria_Export_Excel, 'Kriteria - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }


    public function export_pdf()
    {
        $kriterias = Kriteria::all();

        $pdf = PDF::loadView('PDF.kriteria', compact('kriterias'))->setPaper('a4', 'landscape');;

        return $pdf->download('Kriteria - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
