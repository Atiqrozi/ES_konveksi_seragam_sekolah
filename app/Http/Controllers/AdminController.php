<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GajiPegawai;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\AdminUpdateRequest;
use App\Exports\Admin_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\User\JenisKelaminAdminChart;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('list_admin', User::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $admins = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->role('Admin')
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('users.admin.index', compact('admins', 'search', 'sortBy', 'sortDirection'));
    }


    public function diagram(JenisKelaminAdminChart $jk)
    {
        $total_admin = User::role('Admin')->count();
        $admin_laki = User::where('jenis_kelamin', 'Laki-Laki')->role('Admin')->count();
        $admin_perempuan = User::where('jenis_kelamin', 'Perempuan')->role('Admin')->count();
        
        return view('users.admin.diagram', [
            'jk' => $jk->build(),
            'total_admin' => $total_admin,
            'admin_laki' => $admin_laki,
            'admin_perempuan' => $admin_perempuan,
        ]);
    } 


    public function create(Request $request): View
    {
        $this->authorize('create_admin', User::class);

        $roles = Role::get();

        return view('users.admin.create', compact('roles'));
    }


    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create_admin', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $admin = User::create($validated);

        $admin->syncRoles('Admin');
        
        return redirect()
            ->route('admin.index')
            ->withSuccess(__('crud.common.created'));
    }

    
    public function show(Request $request, User $admin): View
    {
        $this->authorize('view_admin', $admin);

        return view('users.admin.show', compact('admin'));
    }

 
    public function edit(Request $request, User $admin): View
    {
        $this->authorize('update_admin', $admin);

        $roles = Role::get();

        return view('users.admin.edit', compact('admin', 'roles'));
    }

 
    public function update(
        AdminUpdateRequest $request,
        User $admin
    ): RedirectResponse {
        $this->authorize('update_admin', $admin);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $admin->update($validated);

        return redirect()
            ->route('admin.edit', $admin)
            ->withSuccess(__('crud.common.saved'));
    }

  
    public function destroy(Request $request, User $admin): RedirectResponse
    {
        $this->authorize('delete_admin', $admin);

        $admin->delete();

        return redirect()
            ->route('admin.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Admin_Export_Excel, 'Admin - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $admins = User::role('Admin')->get();

        $pdf = PDF::loadView('PDF.admin', compact('admins'))->setPaper('a4', 'landscape');;

        return $pdf->download('Admin - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
