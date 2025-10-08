<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\KategoriStoreRequest;
use App\Http\Requests\KategoriUpdateRequest;

class KategoriController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Kategori::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'id');
        $sortDirection = $request->get('sort_direction', 'desc');

        $kategoris = Kategori::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.kategori.index', compact('kategoris', 'search', 'sortBy', 'sortDirection'));
    }


    public function create(Request $request): View
    {
        $this->authorize('create', Kategori::class);

        return view('masterdata.kategori.create');
    }


    public function store(KategoriStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Kategori::class);

        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('public/kategori');
        } else {
            return back()->withErrors(['foto' => 'Gambar kategori wajib diunggah'])->withInput();
        }

        $kategori = Kategori::create($validated);

        return redirect()
            ->route('kategoris.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, Kategori $kategori): View
    {
        $this->authorize('view', $kategori);

        return view('masterdata.kategori.show', compact('kategori'));
    }


    public function edit(Request $request, Kategori $kategori): View
    {
        $this->authorize('update', $kategori);

        return view('masterdata.kategori.edit', compact('kategori'));
    }


    public function update(KategoriUpdateRequest $request, Kategori $kategori): RedirectResponse
    {
        $this->authorize('update', $kategori);

        $validated = $request->validated();

        if ($request->hasFile('foto')) {
            if ($kategori->foto) {
                Storage::delete($kategori->foto);
            }
            $validated['foto'] = $request->file('foto')->store('public/kategori');
        }

        $kategori->update($validated);

        return redirect()
            ->route('kategoris.edit', $kategori)
            ->withSuccess(__('crud.common.saved'));
    }


    public function destroy(Request $request, Kategori $kategori): RedirectResponse
    {
        $this->authorize('delete', $kategori);

        $fileFields = ['foto'];

        foreach ($fileFields as $field) {
            if (!empty($kategori->$field) && Storage::exists($kategori->$field)) {
                Storage::delete($kategori->$field);
            }
        }

        $kategori->delete();

        return redirect()
            ->route('kategoris.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
