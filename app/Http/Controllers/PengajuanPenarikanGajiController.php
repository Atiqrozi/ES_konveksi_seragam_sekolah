<?php

namespace App\Http\Controllers;

use App\Models\PenarikanGaji;
use App\Models\GajiPegawai;
use App\Models\Kegiatan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Exports\Pengajuan_Penarikan_Gaji_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PengajuanPenarikanGajiController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', PenarikanGaji::class);

        $gaji_pegawai = GajiPegawai::where('pegawai_id', Auth::user()->id)->first();

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
        
        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $pengajuan_penarikan_gajis = PenarikanGaji::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->when($sortBy === 'nama_pegawai', function ($query) use ($sortDirection) {
                return $query->join('users', 'penarikan_gajis.pegawai_id', '=', 'users.id')
                            ->orderBy('users.nama', $sortDirection);
            }, function ($query) use ($sortBy, $sortDirection) {
                return $query->orderBy($sortBy, $sortDirection);
            })
            ->where('pegawai_id', Auth::user()->id)
            ->paginate($paginate)
            ->withQueryString();

        $count_ajuan = PenarikanGaji::query()
            ->where('pegawai_id', Auth::user()->id)
            ->where('status', 'Diajukan')
            ->orderBy('id', 'desc')
            ->get();

        return view('gaji.pengajuan_penarikan_gaji.index', compact('pengajuan_penarikan_gajis', 'search', 'gaji_pegawai', 'detail_gaji_pegawais', 'count_ajuan', 'sortBy', 'sortDirection'));
    }


    
    public function show(Request $request, PenarikanGaji $pengajuan_penarikan_gaji): View
    {
        $this->authorize('view', $pengajuan_penarikan_gaji);

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
            ->select(
                'pekerjaans.id', 
                'pekerjaans.nama_pekerjaan', 
                'pekerjaans.gaji_per_pekerjaan', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(pekerjaans.gaji_per_pekerjaan AS DECIMAL(10, 2))) as total_gaji_per_pekerjaan')
            )
            ->where('kegiatans.user_id', $pengajuan_penarikan_gaji->pegawai_id)
            ->whereBetween('kegiatans.kegiatan_dibuat', [$pengajuan_penarikan_gaji->mulai_tanggal, $pengajuan_penarikan_gaji->akhir_tanggal])   
            ->groupBy('pekerjaans.id', 'pekerjaans.nama_pekerjaan', 'pekerjaans.gaji_per_pekerjaan')
            ->get();  
            
        return view('gaji.pengajuan_penarikan_gaji.show', compact('pengajuan_penarikan_gaji', 'detail_gaji_pegawais'));
    }


    public function ajukan(Request $request, PenarikanGaji $pengajuan_penarikan_gaji): RedirectResponse 
    {
        $this->authorize('create', $pengajuan_penarikan_gaji);

        $gaji_pegawai = GajiPegawai::where('pegawai_id', Auth::user()->id)->first();

        $count_ajuan = PenarikanGaji::query()
            ->where('pegawai_id', Auth::user()->id)
            ->where('status', 'Diajukan')
            ->orderBy('id', 'desc')
            ->get();

        if (count($count_ajuan) < 1)
        {
            $ajuan = new PenarikanGaji();
            $ajuan->pegawai_id = Auth::user()->id;  
            $ajuan->gaji_yang_diajukan = $gaji_pegawai->total_gaji_yang_bisa_diajukan;
            $ajuan->status = 'Diajukan';
            $ajuan->mulai_tanggal = $gaji_pegawai->terhitung_tanggal;
            $ajuan->akhir_tanggal = now();
            $ajuan->save();

            return redirect()
                ->route('pengajuan_penarikan_gaji.index')
                ->withSuccess(__('Berhasil mengajukan'));
        }

        else 
        {
            return redirect()
                ->route('pengajuan_penarikan_gaji.index');
        }
    }


    public function destroy(
        Request $request,
        PenarikanGaji $pengajuan_penarikan_gaji
    ): RedirectResponse {
        $this->authorize('delete', $pengajuan_penarikan_gaji);

        $pengajuan_penarikan_gaji->delete();

        return redirect()
            ->route('pengajuan_penarikan_gaji.index')
            ->withSuccess(__('crud.common.removed'));
    }

    
    public function export_excel()
    {
        return Excel::download(new Pengajuan_Penarikan_Gaji_Export_Excel, 'Pengajuan Penarikan Gaji ( ' . Auth::user()->nama . ' ) - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $pengajuan_penarikan_gajis = PenarikanGaji::where('pegawai_id', 'LIKE', Auth::user()->id)->get();

        $pdf = PDF::loadView('PDF.pengajuan_penarikan_gaji', compact('pengajuan_penarikan_gajis'))->setPaper('a4', 'landscape');;

        return $pdf->download('Pengajuan Penarikan Gaji ( ' . Auth::user()->nama . ' ) - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    public function export_slip_gaji($id)
    {
        $this->authorize('view', PenarikanGaji::findOrFail($id));
        
        $penarikan_gaji = PenarikanGaji::findOrFail($id);
        
        // Pastikan pegawai hanya bisa download slip gaji mereka sendiri
        if ($penarikan_gaji->pegawai_id != Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
            ->select(
                'pekerjaans.id', 
                'pekerjaans.nama_pekerjaan', 
                'pekerjaans.gaji_per_pekerjaan', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(pekerjaans.gaji_per_pekerjaan AS DECIMAL(10, 2))) as total_gaji_per_pekerjaan')
            )
            ->where('kegiatans.user_id', $penarikan_gaji->pegawai_id)
            ->whereBetween('kegiatans.kegiatan_dibuat', [$penarikan_gaji->mulai_tanggal, $penarikan_gaji->akhir_tanggal])   
            ->groupBy('pekerjaans.id', 'pekerjaans.nama_pekerjaan', 'pekerjaans.gaji_per_pekerjaan')
            ->get();  

        // Hitung tinggi dinamis berdasarkan jumlah item
        $itemCount = count($detail_gaji_pegawais);
        $baseHeight = 18; // Header toko
        $employeeInfoHeight = 10; // Info pegawai
        $tableHeaderHeight = 5; // Header tabel
        $itemHeight = 4; // Tinggi per item
        $totalHeight = 12; // Total dan footer
        $signatureHeight = 20; // Tanda tangan
        $bottomMargin = 5; // Margin bawah

        $dynamicHeight = $baseHeight + $employeeInfoHeight + $tableHeaderHeight + ($itemCount * $itemHeight) + $totalHeight + $signatureHeight + $bottomMargin;

        $pdf = createPdfWithOptions(
            'PDF.slip_gaji',
            compact('penarikan_gaji', 'detail_gaji_pegawais'),
            [80, $dynamicHeight], // width 80mm, height dinamis
            'portrait'
        );

        return $pdf->download('Slip Gaji - ' . $penarikan_gaji->user->nama . ' - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Display slip gaji print preview
     */
    public function print_slip_gaji($id): View
    {
        $this->authorize('view', PenarikanGaji::findOrFail($id));
        
        $penarikan_gaji = PenarikanGaji::findOrFail($id);
        
        // Pastikan pegawai hanya bisa print slip gaji mereka sendiri
        if ($penarikan_gaji->pegawai_id != Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
            ->select(
                'pekerjaans.id', 
                'pekerjaans.nama_pekerjaan', 
                'pekerjaans.gaji_per_pekerjaan', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(pekerjaans.gaji_per_pekerjaan AS DECIMAL(10, 2))) as total_gaji_per_pekerjaan')
            )
            ->where('kegiatans.user_id', $penarikan_gaji->pegawai_id)
            ->whereBetween('kegiatans.kegiatan_dibuat', [$penarikan_gaji->mulai_tanggal, $penarikan_gaji->akhir_tanggal])   
            ->groupBy('pekerjaans.id', 'pekerjaans.nama_pekerjaan', 'pekerjaans.gaji_per_pekerjaan')
            ->get();

        return view('print.slip_gaji', compact('penarikan_gaji', 'detail_gaji_pegawais'));
    }
}
