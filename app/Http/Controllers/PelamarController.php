<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pelamar;
use App\Models\Kriteria;
use App\Models\WsmPelamar;
use App\Models\WaktuOpenLamaran;
use App\Models\PosisiLowongan;
use App\Charts\Pelamar\WSMChart;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PelamarStoreRequest;
use App\Http\Requests\PelamarUpdateRequest;
use App\Http\Requests\PelamarUpdateWaktuRequest;
use App\Exports\Pelamar_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use App\Services\FonnteService;

class PelamarController extends Controller
{
    protected $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    public function index(Request $request): View
    {
        $this->authorize('view-any', Pelamar::class);

        $posisi_lowongans = PosisiLowongan::pluck('nama_posisi', 'id');
        $posisi_nama = $request->input('posisi_nama');

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $pelamars = Pelamar::query()
            ->when($posisi_nama, function ($query) use ($posisi_nama) {
                $query->where('posisi_id', $posisi_nama);
            })
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('alamat', 'LIKE', "%{$search}%");
            })
            ->whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        $recruitment = WaktuOpenLamaran::first();

        return view('hiring.pelamar.index', compact('pelamars', 'search', 'sortBy', 'sortDirection', 'recruitment', 'posisi_lowongans'));
    }


    public function diagram(WSMChart $wsm)
    {
        $total_pelamar = Pelamar::whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])->count();
        $belum_diatur_waktu_wawancara = Pelamar::where('status', 'Diajukan')->count();
        $belum_diwawancara = Pelamar::where('status', 'Belum Wawancara')->count();
        $pelamar_laki = Pelamar::where('jenis_kelamin', 'Laki-Laki')->whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])->count();
        $pelamar_perempuan = Pelamar::where('jenis_kelamin', 'Perempuan')->whereIn('status', ['Diajukan', 'Belum Wawancara', 'Sudah Wawancara'])->count();
        
        return view('hiring.pelamar.diagram', [
            'wsm' => $wsm->build(),
            'total_pelamar' => $total_pelamar,
            'belum_diatur_waktu_wawancara' => $belum_diatur_waktu_wawancara,
            'belum_diwawancara' => $belum_diwawancara,
            'pelamar_laki' => $pelamar_laki,
            'pelamar_perempuan' => $pelamar_perempuan,
        ]);
    } 

    
    public function create(Request $request): RedirectResponse|View
    {
        $auth = 'create';

        $recruitment = WaktuOpenLamaran::first();

        if ($recruitment && $recruitment->active == 0) {
            // Jika `active` adalah 0, redirect ke halaman lain atau tampilkan pesan error
            return redirect()->route('home');
        }
        
        $posisi_lowongans = PosisiLowongan::pluck('nama_posisi', 'id');

        return view('hiring.pelamar.create', compact('auth', 'posisi_lowongans'));
    }



    
    public function store(PelamarStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('public/pelamar/foto');
        }

        if ($request->hasFile('cv')) {
            $validated['cv'] = $request->file('cv')->store('public/pelamar/cv');
        }

        $pelamar = Pelamar::create($validated);

        // Get total pelamar
        $total_pelamar = Pelamar::where('status', 'Diajukan')->count();

        // Get all admin users
        $adminUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'Admin');
        })->get();

        // Prepare message
        $message = "Lamaran baru telah diajukan oleh {$pelamar->nama}. Saat ini terdapat {$total_pelamar} lamaran yang belum diatur waktu wawancaranya. Silakan cek detailnya di sistem.";

        // Send WhatsApp message to all admins
        foreach ($adminUsers as $admin) {
            $target = $this->formatPhoneNumber($admin->no_telepon);
            $this->fonnte->sendMessage($target, $message);
        }

        return redirect()
            ->route('ajukan_lamaran')
            ->withSuccess(__('Berhasil mengajukan lamaran'));
    }

    
    public function show(Request $request, Pelamar $pelamar): View
    {
        $this->authorize('view', $pelamar);

        $kriteria = Kriteria::all();

        return view('hiring.pelamar.show', compact('pelamar', 'kriteria'));
    }

    
    public function edit(Request $request, Pelamar $pelamar): View
    {
        $this->authorize('update', $pelamar);

        $auth = 'edit';

        $kriteria = Kriteria::all();

        return view('hiring.pelamar.edit', compact('pelamar', 'auth', 'kriteria'));
    }

    
    public function update(PelamarUpdateRequest $request, Pelamar $pelamar): RedirectResponse
    {
        $this->authorize('update', $pelamar);

        $validated = $request->validated();

        // Simpan nilai WSM ke model Pelamar
        $pelamar->weighted_sum_model = $this->calculateWSM($validated);
        $pelamar->update($validated);
        $pelamar->status = 'Sudah Wawancara';
        $pelamar->save();

        // Simpan nilai dari setiap kriteria ke dalam tabel wsm_pelamar
        $this->saveWsmPelamar($pelamar, $validated);

        return redirect()
            ->route('pelamar.edit', $pelamar)
            ->withSuccess(__('Berhasil menilai pelamar'));
    }


    protected function calculateWSM(array $validated): float
    {
        $wsmValue = 0;
        $totalWeight = 0;

        $kriteria = Kriteria::all();

        foreach ($kriteria as $kriterium) {
            $columnName = strtolower(str_replace(' ', '_', $kriterium->nama));
            $skor = $validated[$columnName];
            $bobot = $kriterium->bobot;

            $wsmValue += $skor * $bobot;
            $totalWeight += $bobot;
        }

        return ($totalWeight > 0) ? $wsmValue / $totalWeight : 0;
    }
    

    protected function saveWsmPelamar(Pelamar $pelamar, array $validated): void
    {
        $kriteria = Kriteria::all();

        foreach ($kriteria as $kriterium) {
            $columnName = strtolower(str_replace(' ', '_', $kriterium->nama));
            $skor = $validated[$columnName];

            // Cari atau buat record WsmPelamar untuk kriteria ini
            $wsmPelamar = WsmPelamar::updateOrCreate(
                ['pelamar_id' => $pelamar->id, 'kriteria_id' => $kriterium->id],
                ['skor' => $skor]
            );
        }
    }


    public function edit_waktu(Request $request, Pelamar $pelamar): View
    {
        $this->authorize('update', $pelamar);

        $auth = 'waktu';

        return view('hiring.pelamar.edit', compact('pelamar', 'auth'));
    }


    public function update_waktu(
        PelamarUpdateWaktuRequest $request, 
        Pelamar $pelamar
    ): RedirectResponse {
        $this->authorize('update', $pelamar);
    
        $validated = $request->validated();
    
        $pelamar->update($validated);
    
        $pelamar->status = "Belum Wawancara";
        $pelamar->save();
    
        // Hanya jalankan kode Google Calendar jika tidak dalam mode testing
        if (!app()->environment('testing')) {
            $calendarId = config('google-calendar.calendar_id');
    
            if ($calendarId) {
                $events = Event::get();
    
                // Filter event berdasarkan nama
                $foundEvent = $events->first(function ($event) use ($pelamar) {
                    return $event->name === 'Wawancara ' . $pelamar->nama;
                });
    
                if ($foundEvent) {
                    $foundEvent->delete();
    
                    $new_event = Event::create([
                        'name' => 'Wawancara ' . $pelamar->nama,
                        'startDateTime' => Carbon::parse($request->mulai_wawancara),
                        'endDateTime' => Carbon::parse($request->selesai_wawancara),
                    ]);
                } else {
                    $new_event = Event::create([
                        'name' => 'Wawancara ' . $pelamar->nama,
                        'startDateTime' => Carbon::parse($request->mulai_wawancara),
                        'endDateTime' => Carbon::parse($request->selesai_wawancara),
                    ]);
                }
            }
        }
    
        $target = $this->formatPhoneNumber($pelamar->no_telepon); 
        $message = 
            "Halo $pelamar->nama,\n\nKami dari tim Agung's Collection senang untuk mengundang Anda untuk tahap wawancara di perusahaan kami.\n\nDetail Wawancara:\n\nTanggal    : " . Carbon::parse($request->mulai_wawancara)->format('Y-m-d') . "\nWaktu      : " . Carbon::parse($request->mulai_wawancara)->format('H:i') . " - " . Carbon::parse($request->selesai_wawancara)->format('H:i') . "\nTempat    : Kantor Agung's Collection (Ds. Sraturejo RT 02 RW 06, Kec. Baureno, Kab. Bojonegoro)\n\nMohon konfirmasi kehadiran Anda untuk wawancara ini dengan membalas whatsapp ini atau menghubungi kami di +6281216511755.\n\nTerima kasih dan kami tunggu kehadiran Anda.";
    
        $this->fonnte->sendMessage($target, $message);
    
        return redirect()
            ->route('pelamar.edit_waktu', $pelamar)
            ->withSuccess(__('Berhasil memperbaharui waktu wawancara'));
    }
    


    public function terima_lamaran(Request $request, Pelamar $pelamar): RedirectResponse 
    {
        $this->authorize('update', $pelamar);
    
        $pelamar->status = 'Diterima';
        $pelamar->save();

        $target = $this->formatPhoneNumber($pelamar->no_telepon); 
        $message = 
            "Halo $pelamar->nama,\n\nSelamat! Kami dengan senang hati menginformasikan bahwa Anda telah diterima sebagai bagian dari Agung's Collection. Berdasarkan proses seleksi dan wawancara yang telah Anda lalui, kami yakin Anda memiliki kualifikasi yang dibutuhkan.\n\nDetail pekerjaan dan langkah selanjutnya akan kami kirimkan melalui email. Harap periksa email Anda secara berkala untuk informasi lebih lanjut.\n\nJika Anda memiliki pertanyaan atau membutuhkan informasi tambahan, jangan ragu untuk menghubungi kami.\n\nSekali lagi, selamat bergabung di Agung's Collection! Kami menantikan kontribusi Anda, salam hangat.";

        $this->fonnte->sendMessage($target, $message);
    
        return redirect()
            ->route('pelamar.index')
            ->withSuccess(__('Berhasil menerima pelamar'));
    }


    public function tolak_lamaran(Request $request, Pelamar $pelamar): RedirectResponse 
    {
        $this->authorize('update', $pelamar);
    
        $pelamar->status = 'Ditolak';
        $pelamar->save();

        $target = $this->formatPhoneNumber($pelamar->no_telepon); 
        $message = 
            "Halo $pelamar->nama,\n\nTerima kasih atas partisipasi Anda dalam proses rekrutmen di Agung's Collection. Kami sangat menghargai waktu dan usaha yang telah Anda berikan.\n\nSetelah mempertimbangkan dengan seksama, kami menyesal harus menginformasikan bahwa kami tidak dapat menerima Anda di perusahaan kami. Keputusan ini berdasarkan pertimbangan yang sangat ketat.\n\nKami akan menyimpan informasi Anda dalam database kami, dan jika ada peluang yang lebih sesuai di masa depan, kami akan menghubungi Anda kembali.\n\nKami berharap Anda mendapatkan kesempatan yang lebih baik di lain waktu dan sukses dalam karier Anda ke depannya, salam hangat.";

        $this->fonnte->sendMessage($target, $message);
    
        return redirect()
            ->route('pelamar.index')
            ->withSuccess(__('Berhasil menolak pelamar'));
    }


    private function formatPhoneNumber($phone)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/\D/', '', $phone);

        // If the phone starts with a 0, replace it with 62 (Indonesian country code)
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    } 

    
    public function destroy(
        Request $request,
        Pelamar $pelamar
    ): RedirectResponse {
        $this->authorize('delete', $pelamar);
        $pelamar->delete();

        return redirect()
            ->route('pelamar.index')
            ->withSuccess(__('crud.common.removed'));
    }


    public function open_recruitment(Request $request, Pelamar $pelamar): RedirectResponse
    {
        $this->authorize('view-any', $pelamar);

        $rules = [
            'active' => 'required|boolean',
        ];

        $request->validate($rules);

        $recruitment = WaktuOpenLamaran::first();

        $recruitment->update([
            'active' => $request->input('active'),
        ]);

        return redirect()
            ->route('pelamar.index')
            ->withSuccess(__('Berhasil open/close recruitment'));
    }


    public function export_excel()
    {
        return Excel::download(new Pelamar_Export_Excel, 'Pelamar - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
}
