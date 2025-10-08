<?php

namespace App\Http\Controllers;

use App\Models\CalonMitra;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Exports\CalonMitra_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CalonMitraController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', CalonMitra::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $calon_mitras = CalonMitra::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('nomor_wa', 'LIKE', "%{$search}%")
                    ->orWhere('alamat', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.calon_mitra.index', compact('calon_mitras', 'search', 'sortBy', 'sortDirection'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_wa' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        CalonMitra::create([
            'nama' => $request->nama,
            'nomor_wa' => $request->nomor_wa,
            'alamat' => $request->alamat,
        ]);

        return redirect('/#kontak')->with('success', 'Berhasil dikirim, tunggu kami hubungi');
    }


    public function show(Request $request, CalonMitra $calon_mitra): View
    {
        $this->authorize('view', $calon_mitra);

        return view('masterdata.calon_mitra.show', compact('calon_mitra'));
    }


    public function export_excel()
    {
        return Excel::download(new CalonMitra_Export_Excel, 'Calon Mitra - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $calon_mitras = CalonMitra::all();

        $pdf = PDF::loadView('PDF.calon_mitra', compact('calon_mitras'))->setPaper('a4', 'potrait');;

        return $pdf->download('Calon Mitra - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
