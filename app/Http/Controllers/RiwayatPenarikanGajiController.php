<?php

namespace App\Http\Controllers;

use App\Models\PenarikanGaji;
use App\Models\GajiPegawai;
use App\Models\Produk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Exports\Riwayat_Penarikan_Gaji_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Charts\RiwayatPenarikanGaji\RiwayatPenarikanGajiChart;

class RiwayatPenarikanGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('list_riwayat_semua_ajuan', PenarikanGaji::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');
        // $start_date = $request->input('start_date');
        // $end_date = $request->input('end_date');

        $riwayat_penarikan_gajis = PenarikanGaji::query()
            // ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            //     $query->whereDate('updated_at', '>=', $start_date)
            //         ->whereDate('updated_at', '<=', $end_date);
            // })
            ->join('users', 'penarikan_gajis.pegawai_id', '=', 'users.id')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('nama', 'LIKE', "%{$search}%");
                    });
                });
            })
            ->where('status', 'Diterima')
            ->orderBy(
                $sortBy == 'nama_pegawai' ? 'users.nama' : "penarikan_gajis.{$sortBy}",
                $sortDirection
            )
            ->select('penarikan_gajis.*')
            ->paginate($paginate)
            ->withQueryString();


        return view('gaji.riwayat_penarikan_gaji.index', compact('riwayat_penarikan_gajis', 'search', 'sortBy', 'sortDirection'));
    }

    
    public function show(Request $request, PenarikanGaji $riwayat_penarikan_gaji): View
    {
        $this->authorize('view_riwayat_semua_ajuan', $riwayat_penarikan_gaji);

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
            ->select(
                'pekerjaans.id', 
                'pekerjaans.nama_pekerjaan', 
                'pekerjaans.gaji_per_pekerjaan', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(pekerjaans.gaji_per_pekerjaan AS DECIMAL(10, 2))) as total_gaji_per_pekerjaan')
            )
            ->where('kegiatans.user_id', $riwayat_penarikan_gaji->pegawai_id)
            ->where('kegiatans.status_kegiatan', 'Sudah Ditarik')
            ->whereBetween('kegiatans.kegiatan_dibuat', [$riwayat_penarikan_gaji->mulai_tanggal, $riwayat_penarikan_gaji->akhir_tanggal])   
            ->groupBy('pekerjaans.id', 'pekerjaans.nama_pekerjaan', 'pekerjaans.gaji_per_pekerjaan')
            ->get();

        return view('gaji.riwayat_penarikan_gaji.show', compact('riwayat_penarikan_gaji', 'detail_gaji_pegawais'));
    }


    public function export_excel()
    {
        return Excel::download(new Riwayat_Penarikan_Gaji_Export_Excel, 'Riwayat Penarikan Gaji (Semua) - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $riwayat_penarikan_gajis = PenarikanGaji::all();

        $pdf = PDF::loadView('PDF.riwayat_penarikan_gaji', compact('riwayat_penarikan_gajis'))->setPaper('a4', 'landscape');;

        return $pdf->download('Riwayat Penarikan Gaji (Semua) - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
