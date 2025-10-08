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
use App\Http\Requests\SalesUpdateRequest;
use App\Exports\Sales_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\User\JenisKelaminSalesChart;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('list_sales', User::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $sales = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })
            ->role('Sales')
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('users.sales.index', compact('sales', 'search', 'sortBy', 'sortDirection'));
    }


    public function diagram(JenisKelaminSalesChart $jk)
    {
        $total_sales = User::role('Sales')->count();
        $sales_laki = User::where('jenis_kelamin', 'Laki-Laki')->role('Sales')->count();
        $sales_perempuan = User::where('jenis_kelamin', 'Perempuan')->role('Sales')->count();
        
        return view('users.sales.diagram', [
            'jk' => $jk->build(),
            'total_sales' => $total_sales,
            'sales_laki' => $sales_laki,
            'sales_perempuan' => $sales_perempuan,
        ]);
    } 


    public function create(Request $request): View
    {
        $this->authorize('create_sales', User::class);

        $roles = Role::get();

        return view('users.sales.create', compact('roles'));
    }


    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create_sales', User::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $sale = User::create($validated);

        $sale->syncRoles('Sales');

        return redirect()
            ->route('sales.index')
            ->withSuccess(__('crud.common.created'));
    }

    
    public function show(Request $request, User $sale): View
    {
        $this->authorize('view_sales', $sale);

        $detail_transaksis = DB::table('invoices')
            ->where('customer_id', $sale->id)   
            ->get(); 
        
        return view('users.sales.show', compact('sale', 'detail_transaksis'));
    }

 
    public function edit(Request $request, User $sale): View
    {
        $this->authorize('update_sales', $sale);

        $roles = Role::get();

        return view('users.sales.edit', compact('sale', 'roles'));
    }

 
    public function update(
        SalesUpdateRequest $request,
        User $sale
    ): RedirectResponse {
        $this->authorize('update_sales', $sale);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $sale->update($validated);

        return redirect()
            ->route('sales.edit', $sale)
            ->withSuccess(__('crud.common.saved'));
    }

  
    public function destroy(Request $request, User $sale): RedirectResponse
    {
        $this->authorize('delete_sales', $sale);

        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Sales_Export_Excel, 'Sales - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $sales = User::role('Sales')->get();

        $pdf = PDF::loadView('PDF.sales', compact('sales'))->setPaper('a4', 'landscape');;

        return $pdf->download('Sales - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
