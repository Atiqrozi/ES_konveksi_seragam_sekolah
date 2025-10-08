<?php

namespace App\Http\Controllers;

use App\Models\PenarikanGaji;
use App\Models\Produk;
use App\Models\Pekerjaan;
use App\Models\GajiPegawai;
use App\Models\Kegiatan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PengajuanPenarikanGajiUpdateRequest;
use App\Exports\Pesanan_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KonfirmasiPenarikanGajiController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('list_ajuan', PenarikanGaji::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $konfirmasi_ajuans = PenarikanGaji::query()
            ->join('users', 'penarikan_gajis.pegawai_id', '=', 'users.id')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->where('status', 'Diajukan')
            ->orderBy(
                $sortBy == 'nama_pegawai' ? 'users.nama' : "penarikan_gajis.{$sortBy}",
                $sortDirection
            )
            ->select('penarikan_gajis.*')
            ->paginate($paginate)
            ->withQueryString();

        return view('gaji.konfirmasi_penarikan_gaji.index', compact('konfirmasi_ajuans', 'search', 'sortBy', 'sortDirection'));
    }

    public function show(Request $request, PenarikanGaji $konfirmasi_penarikan_gaji): View
    {
        $this->authorize('list_ajuan', $konfirmasi_penarikan_gaji);

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
            ->select(
                'pekerjaans.id', 
                'pekerjaans.nama_pekerjaan', 
                'pekerjaans.gaji_per_pekerjaan', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(pekerjaans.gaji_per_pekerjaan AS DECIMAL(10, 2))) as total_gaji_per_pekerjaan')
            )
            ->where('kegiatans.user_id', $konfirmasi_penarikan_gaji->pegawai_id)
            ->where('kegiatans.status_kegiatan', 'Belum Ditarik')
            ->whereBetween('kegiatans.kegiatan_dibuat', [$konfirmasi_penarikan_gaji->mulai_tanggal, $konfirmasi_penarikan_gaji->akhir_tanggal])  
            ->groupBy('pekerjaans.id', 'pekerjaans.nama_pekerjaan', 'pekerjaans.gaji_per_pekerjaan')
            ->get(); 

        return view('gaji.konfirmasi_penarikan_gaji.show', compact('konfirmasi_penarikan_gaji', 'detail_gaji_pegawais'));
    }


    public function terima_ajuan(Request $request, PenarikanGaji $konfirmasi_penarikan_gaji): RedirectResponse 
    {
        $this->authorize('terima_ajuan', $konfirmasi_penarikan_gaji);

        $merubah_status_kegiatan = Kegiatan::where('user_id', $konfirmasi_penarikan_gaji->pegawai_id)
                    ->whereBetween('kegiatan_dibuat', [$konfirmasi_penarikan_gaji->mulai_tanggal, $konfirmasi_penarikan_gaji->akhir_tanggal])
                    ->where('status_kegiatan', 'Belum Ditarik')              
                    ->get();
        
        foreach ($merubah_status_kegiatan as $kegiatan) 
        {
            $kegiatan->status_kegiatan = 'Sudah Ditarik';
            $kegiatan->save();
        }

        $kegiatan_belum_ditarik = Kegiatan::where('user_id', $konfirmasi_penarikan_gaji->pegawai_id)
                    ->where('kegiatan_dibuat', '<', now())
                    ->where('status_kegiatan', 'Belum Ditarik')              
                    ->get();
        
        $total_gaji = 0;

        foreach ($kegiatan_belum_ditarik as $kegiatan) 
        {
            $pekerjaan = Pekerjaan::find($kegiatan->pekerjaan_id); 
            if ($pekerjaan) {
                $total_gaji += $kegiatan->jumlah_kegiatan * $pekerjaan->gaji_per_pekerjaan;
            }
        }
    
        $konfirmasi_penarikan_gaji->status = 'Diterima';
        $konfirmasi_penarikan_gaji->gaji_diberikan = now();
        $konfirmasi_penarikan_gaji->save();

        $gaji_pegawai = GajiPegawai::where('pegawai_id', $konfirmasi_penarikan_gaji->pegawai_id)->first();
        $gaji_pegawai->terhitung_tanggal = $konfirmasi_penarikan_gaji->akhir_tanggal;
        $gaji_pegawai->total_gaji_yang_bisa_diajukan = $total_gaji;
        $gaji_pegawai->save();
    
        return redirect()
            ->route('konfirmasi_penarikan_gaji.index')
            ->withSuccess(__('Berhasil menerima ajuan'));
    }

    public function tolak_ajuan(Request $request, PenarikanGaji $konfirmasi_penarikan_gaji): RedirectResponse 
    {
        $this->authorize('tolak_ajuan', $konfirmasi_penarikan_gaji);
        // dd($konfirmasi_penarikan_gaji);
    
        $konfirmasi_penarikan_gaji->status = 'Ditolak';
        $konfirmasi_penarikan_gaji->save();
    
        return redirect()
            ->route('konfirmasi_penarikan_gaji.index')
            ->withSuccess(__('Berhasil menolak ajuan'));
    }
}
