<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GajiPegawai;
use App\Models\Kegiatan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\PegawaiUpdateRequest;
use App\Exports\Pegawai_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\User\JenisKelaminPegawaiChart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('list_pegawai', User::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $pegawais = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->role('Pegawai')
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('users.pegawai.index', compact('pegawais', 'search', 'sortBy', 'sortDirection'));
    }


    public function diagram(JenisKelaminPegawaiChart $jk)
    {
        $total_pegawai = User::role('Pegawai')->count();
        $pegawai_laki = User::where('jenis_kelamin', 'Laki-Laki')->role('Pegawai')->count();
        $pegawai_perempuan = User::where('jenis_kelamin', 'Perempuan')->role('Pegawai')->count();
        
        return view('users.pegawai.diagram', [
            'jk' => $jk->build(),
            'total_pegawai' => $total_pegawai,
            'pegawai_laki' => $pegawai_laki,
            'pegawai_perempuan' => $pegawai_perempuan,
        ]);
    } 


    public function create(Request $request): View
    {
        $this->authorize('create_pegawai', User::class);

        $roles = Role::get();

        return view('users.pegawai.create', compact('roles'));
    }


    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create_pegawai', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $pegawai = User::create($validated);

        $pegawai->syncRoles('Pegawai');

        $gaji_pegawai = new GajiPegawai();
        $gaji_pegawai->pegawai_id = $pegawai->id; 
        $gaji_pegawai->total_gaji_yang_bisa_diajukan = 0;  
        $gaji_pegawai->terhitung_tanggal = now();   
        $gaji_pegawai->save();

        return redirect()
            ->route('pegawai.index')
            ->withSuccess(__('crud.common.created'));
    }

    
    public function show(Request $request, User $pegawai): View
    {
        $this->authorize('view_pegawai', $pegawai);

        $gaji_pegawai = GajiPegawai::where('pegawai_id', $pegawai->id)->first();

        $kegiatans = Kegiatan::where('user_id', $pegawai->id)->get();

        return view('users.pegawai.show', compact('pegawai', 'gaji_pegawai', 'kegiatans'));
    }

 
    public function edit(Request $request, User $pegawai): View
    {
        $this->authorize('update_pegawai', $pegawai);

        $roles = Role::get();

        return view('users.pegawai.edit', compact('pegawai', 'roles'));
    }

 
    public function update(
        PegawaiUpdateRequest $request,
        User $pegawai
    ): RedirectResponse {
        $this->authorize('update_pegawai', $pegawai);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $pegawai->update($validated);

        return redirect()
            ->route('pegawai.edit', $pegawai)
            ->withSuccess(__('crud.common.saved'));
    }

  
    public function destroy(Request $request, User $pegawai): RedirectResponse
    {
        $this->authorize('delete_pegawai', $pegawai);

        $pegawai->delete();

        return redirect()
            ->route('pegawai.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Pegawai_Export_Excel, 'Pegawai - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $pegawais = User::role('Pegawai')->with('GajiPegawai')->get();

        $pdf = PDF::loadView('PDF.pegawai', compact('pegawais'))->setPaper('a4', 'landscape');;

        return $pdf->download('Pegawai - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
