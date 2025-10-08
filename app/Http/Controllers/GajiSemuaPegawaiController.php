<?php

namespace App\Http\Controllers;

use App\Models\GajiPegawai;
use App\Models\Kegiatan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Exports\Gaji_Semua_Pegawai_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Charts\GajiPegawai\GajiChart;


class GajiSemuaPegawaiController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', GajiPegawai::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $gaji_semua_pegawais = GajiPegawai::query()
            ->join('users', 'gaji_pegawais.pegawai_id', '=', 'users.id')
            ->when($search, function ($query, $search) {
                return $query->where('users.nama', 'LIKE', "%{$search}%");
            })
            ->orderBy(
                $sortBy == 'nama_pegawai' ? 'users.nama' : "gaji_pegawais.{$sortBy}",
                $sortDirection
            )
            ->select('gaji_pegawais.*')
            ->paginate($paginate)
            ->withQueryString();

        return view('gaji.gaji_semua_pegawai.index', compact('gaji_semua_pegawais', 'search', 'sortBy', 'sortDirection'));
    }



    public function diagram(GajiChart $gaji)
    {
        return view('gaji.gaji_semua_pegawai.diagram', [
            'gaji' => $gaji->build(),
        ]);
    } 

    
    public function show(Request $request, GajiPegawai $gaji_semua_pegawai): View
    {
        $this->authorize('view', $gaji_semua_pegawai);

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
            ->select(
                'pekerjaans.id', 
                'pekerjaans.nama_pekerjaan', 
                'pekerjaans.gaji_per_pekerjaan', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(pekerjaans.gaji_per_pekerjaan AS DECIMAL(10, 2))) as total_gaji_per_pekerjaan')
            )
            ->where('kegiatans.user_id', $gaji_semua_pegawai->pegawai_id)
            ->where('kegiatans.status_kegiatan', 'Belum Ditarik')
            ->whereBetween('kegiatans.kegiatan_dibuat', [$gaji_semua_pegawai->terhitung_tanggal, now()])   
            ->groupBy('pekerjaans.id', 'pekerjaans.nama_pekerjaan', 'pekerjaans.gaji_per_pekerjaan')
            ->get(); 
        
        return view('gaji.gaji_semua_pegawai.show', compact('gaji_semua_pegawai', 'detail_gaji_pegawais'));
    }

    
    public function export_excel()
    {
        return Excel::download(new Gaji_Semua_Pegawai_Export_Excel, 'Gaji Semua Pegawai - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $gaji_semua_pegawais = GajiPegawai::all();

        $pdf = PDF::loadView('PDF.gaji_semua_pegawai', compact('gaji_semua_pegawais'))->setPaper('a4', 'potrait');;

        return $pdf->download('Gaji Semua Pegawai - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
