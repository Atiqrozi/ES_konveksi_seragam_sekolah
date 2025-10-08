<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Exports\Permissions_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PermissionController extends Controller
{
    /**
    * Display a listing of the resource.
    */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Permission::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $permissions = Permission::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('r&p.permissions.index', compact('sortBy', 'sortDirection'))
            ->with('permissions', $permissions)
            ->with('search', $search);
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create(): View
    {
        $this->authorize('create', Permission::class);

        $roles = Role::all();
        return view('r&p.permissions.create')->with('roles', $roles);
    }

    /**
    * Store a newly created resource in storage.
    */
    public function store(Request $request): RedirectResponse
    {
        Sanctum::actingAs(request()->user(), [], 'web');

        $this->authorize('create', Permission::class);

        $data = $this->validate($request, [
            'name' => 'required|max:64',
            'roles' => 'array'
        ]);

        $permission = Permission::create($data);
        
        $roles = Role::find($request->roles);
        $permission->syncRoles($roles);

        return redirect()
            ->route('permissions.index')
            ->withSuccess(__('crud.common.created'));
    }

    /**
    * Display the specified resource.
    */
    public function show(Permission $permission): View
    {
        $this->authorize('view', Permission::class);

        $RoleHasPermission = DB::table('role_has_permissions')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->select('roles.*')
            ->where('role_has_permissions.permission_id', $permission->id)
            ->get();

        return view('r&p.permissions.show', [
            'permission' => $permission,
            'RoleHasPermission' => $RoleHasPermission
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(Permission $permission): View
    {
        $this->authorize('update', $permission);

        $roles = Role::get();

        return view('r&p.permissions.edit')
            ->with('permission', $permission)
            ->with('roles', $roles);
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $this->authorize('update', $permission);

        $data = $this->validate($request, [
            'name' => 'required|max:40',
            'roles' => 'array'
        ]);

        $permission->update($data);
        
        $roles = Role::find($request->roles);
        $permission->syncRoles($roles);

        return redirect()
            ->route('permissions.edit', $permission->id)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(Permission $permission): RedirectResponse
    {
        $this->authorize('delete', $permission);

        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Permissions_Export_Excel, 'Permissions - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $permissions = Permission::all();

        $roles = [];

        foreach ($permissions as $permission) {
            $roles[$permission->id] = $permission->roles->pluck('name')->toArray();
        }

        $pdf = PDF::loadView('PDF.permissions', compact('permissions', 'roles'))->setPaper('a4', 'potrait');

        return $pdf->download('Permissions - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
