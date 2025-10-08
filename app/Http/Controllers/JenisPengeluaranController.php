<?php

namespace App\Http\Controllers;

use App\Models\JenisPengeluaran;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\JenisPengeluaranStoreRequest;
use App\Http\Requests\JenisPengeluaranUpdateRequest;

class JenisPengeluaranController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', JenisPengeluaran::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $jenis_pengeluarans = JenisPengeluaran::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_pengeluaran', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.jenis_pengeluaran.index', compact('jenis_pengeluarans', 'search', 'sortBy', 'sortDirection'));
    }


    public function create(Request $request): View
    {
        $this->authorize('create', JenisPengeluaran::class);

        return view('masterdata.jenis_pengeluaran.create');
    }


    public function store(JenisPengeluaranStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', JenisPengeluaran::class);

        $validated = $request->validated();

        $jenis_pengeluaran = JenisPengeluaran::create($validated);

        return redirect()
            ->route('jenis_pengeluaran.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, JenisPengeluaran $jenis_pengeluaran): View
    {
        $this->authorize('view', $jenis_pengeluaran);

        return view('masterdata.jenis_pengeluaran.show', compact('jenis_pengeluaran'));
    }


    public function edit(Request $request, JenisPengeluaran $jenis_pengeluaran): View
    {
        $this->authorize('update', $jenis_pengeluaran);

        return view('masterdata.jenis_pengeluaran.edit', compact('jenis_pengeluaran'));
    }


    public function update(
       JenisPengeluaranUpdateRequest $request,
       JenisPengeluaran $jenis_pengeluaran
    ): RedirectResponse {
        $this->authorize('update', $jenis_pengeluaran);

        $validated = $request->validated();

        $jenis_pengeluaran->update($validated);

        return redirect()
            ->route('jenis_pengeluaran.edit', $jenis_pengeluaran)
            ->withSuccess(__('crud.common.saved'));
    }


    public function destroy(
        Request $request,
        JenisPengeluaran $jenis_pengeluaran
    ): RedirectResponse {
        $this->authorize('delete', $jenis_pengeluaran);

        $jenis_pengeluaran->delete();

        return redirect()
            ->route('jenis_pengeluaran.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
