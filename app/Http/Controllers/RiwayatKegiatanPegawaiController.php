<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Pekerjaan;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\KegiatanStoreRequest;
use App\Http\Requests\KegiatanUpdateRequest;
use App\Exports\Riwayat_Kegiatan_Pegawai_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Charts\RiwayatKegiatan\KegiatanPegawaiChart;
use Carbon\Carbon;

class RiwayatKegiatanPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $this->authorize('list_riwayat_kegiatan_pegawai', Kegiatan::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Pastikan tanggal kedua tidak lebih kecil dari tanggal pertama
        if ($start_date && $end_date && $start_date > $end_date) {
            return redirect()->back()->withErrors(['end_date' => 'Tanggal selesai tidak boleh lebih kecil dari tanggal mulai.']);
        }

        $kegiatans = Kegiatan::query()
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereDate('kegiatan_dibuat', '>=', $start_date)
                    ->whereDate('kegiatan_dibuat', '<=', $end_date);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('pekerjaan', function ($query) use ($search) {
                        $query->where('nama_pekerjaan', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('nama', 'LIKE', "%{$search}%");
                    });
                });
            })
            ->with('pekerjaan')
            ->with('user') 
            ->where('user_id', 'LIKE', Auth::user()->id)
            ->where('status_kegiatan', 'LIKE', 'Sudah Ditarik');

        if ($sortBy === 'kegiatan') {
            $kegiatans = $kegiatans->join('pekerjaans', 'kegiatans.pekerjaan_id', '=', 'pekerjaans.id')
                ->orderBy('pekerjaans.nama_pekerjaan', $sortDirection); 
        } elseif ($sortBy === 'nama_pegawai') {
            $kegiatans = $kegiatans->join('users', 'kegiatans.user_id', '=', 'users.id')
                ->orderBy('users.nama', $sortDirection);
        } else {
            $kegiatans = $kegiatans->orderBy($sortBy, $sortDirection);
        }

        $kegiatans = $kegiatans->paginate($paginate)->withQueryString();


        return view('transaksi.riwayat_kegiatan_pegawai.index', compact('kegiatans', 'search', 'start_date', 'end_date', 'sortBy', 'sortDirection'));
    }


    public function diagram(KegiatanPegawaiChart $kegiatanChart, Request $request)
    {
        // Get the start and end date from the request
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Build the chart with the provided date range
        $kegiatan = $kegiatanChart->build($start_date, $end_date);

        // Calculate total activities within the date range
        $total_kegiatan = Kegiatan::where('status_kegiatan', 'Sudah Ditarik')
            ->where('user_id', Auth::user()->id)
            ->whereBetween('kegiatan_dibuat', [$start_date, $end_date])
            ->sum('jumlah_kegiatan');

        return view('transaksi.riwayat_kegiatan_pegawai.diagram', compact('kegiatan', 'total_kegiatan', 'start_date', 'end_date'));
    } 

    
    public function show(Request $request, Kegiatan $riwayat_kegiatan_pegawai): View
    {
        $this->authorize('view_riwayat_kegiatan_pegawai', $riwayat_kegiatan_pegawai);

        $kegiatans = Kegiatan::where('id', $riwayat_kegiatan_pegawai->id)->get();

        return view('transaksi.riwayat_kegiatan_pegawai.show', compact('riwayat_kegiatan_pegawai', 'kegiatans'));
    }


    public function export_excel()
    {
        return Excel::download(new Riwayat_Kegiatan_Pegawai_Export_Excel, 'Riwayat Kegiatan ( ' . Auth::user()->nama . ' ) - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $kegiatans = Kegiatan::where('user_id', 'LIKE', Auth::user()->id)->get();

        $pdf = PDF::loadView('PDF.riwayat_kegiatan_pegawai', compact('kegiatans'))->setPaper('a4', 'landscape');;

        return $pdf->download('Kegiatan ( ' . Auth::user()->nama . ' ) - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
