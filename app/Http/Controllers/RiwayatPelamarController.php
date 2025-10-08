<?php

namespace App\Http\Controllers;

use App\Models\Pelamar;
use App\Models\Kriteria;
use App\Charts\RiwayatPelamar\WSMChart;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Exports\Riwayat_Pelamar_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RiwayatPelamarController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('list_riwayat_pelamar', Pelamar::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $riwayat_pelamars = Pelamar::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('alamat', 'LIKE', "%{$search}%");
            })
            ->whereIn('status', ['Diterima', 'Ditolak'])
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('hiring.riwayat_pelamar.index', compact('riwayat_pelamars', 'search', 'sortBy', 'sortDirection'));
    }


    public function diagram(WSMChart $wsm)
    {
        $pelamar_diterima = Pelamar::where('status', 'Diterima')->count();
        $pelamar_ditolak = Pelamar::where('status', 'Ditolak')->count();
        
        return view('hiring.riwayat_pelamar.diagram', [
            'wsm' => $wsm->build(),
            'pelamar_diterima' => $pelamar_diterima,
            'pelamar_ditolak' => $pelamar_ditolak,
        ]);
    } 

    
    public function show(Request $request, Pelamar $riwayat_pelamar): View
    {
        $this->authorize('view_riwayat_pelamar', $riwayat_pelamar);

        $kriteria = Kriteria::all();

        return view('hiring.riwayat_pelamar.show', compact('riwayat_pelamar', 'kriteria'));
    }


    public function export_excel()
    {
        return Excel::download(new Riwayat_Pelamar_Export_Excel, 'Riwayat Pelamar - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
}
