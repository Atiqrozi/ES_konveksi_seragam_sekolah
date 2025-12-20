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

    /**
     * Export slip gaji individual pegawai dalam format 80mm
     */
    public function export_slip_gaji($id)
    {
        try {
            $gaji_pegawai = GajiPegawai::with('user')->findOrFail($id);
            
            $this->authorize('view', $gaji_pegawai);

            // Get detail gaji per pekerjaan
            $detail_gaji_pegawais = DB::table('kegiatans')
                ->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
                ->select(
                    'pekerjaans.id', 
                    'pekerjaans.nama_pekerjaan', 
                    'pekerjaans.gaji_per_pekerjaan', 
                    DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                    DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(pekerjaans.gaji_per_pekerjaan AS DECIMAL(10, 2))) as total_gaji_per_pekerjaan')
                )
                ->where('kegiatans.user_id', $gaji_pegawai->pegawai_id)
                ->where('kegiatans.status_kegiatan', 'Belum Ditarik')
                ->whereBetween('kegiatans.kegiatan_dibuat', [$gaji_pegawai->terhitung_tanggal, now()])   
                ->groupBy('pekerjaans.id', 'pekerjaans.nama_pekerjaan', 'pekerjaans.gaji_per_pekerjaan')
                ->get();

            // Hitung panjang dinamis berdasarkan jumlah detail pekerjaan (lebih presisi)
            // Header+Logo: 18mm, Info: 10mm, Table header: 5mm, Per item: 4mm, Total: 12mm, TTD: 20mm, Footer: 5mm
            $itemCount = $detail_gaji_pegawais->count();
            $dynamicHeight = 18 + 10 + 5 + ($itemCount * 4) + 12 + 20 + 5;
            
            $pdf = createPdfWithOptions(
                'PDF.slip_gaji', 
                compact('gaji_pegawai', 'detail_gaji_pegawais'),
                [80, $dynamicHeight]
            );

            return $pdf->download('Slip_Gaji_' . $gaji_pegawai->user->nama . '_' . now()->format('d-m-Y_His') . '.pdf');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat slip gaji: ' . $e->getMessage());
        }
    }
}
