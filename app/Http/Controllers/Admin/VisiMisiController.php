<?php

namespace App\Http\Controllers\Admin;

use App\Models\VisiMisi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VisiMisiController extends AdminController
{
    public function index(Request $request): View
    {
        $desa = $this->currentDesa($request);

        return view('admin.visi-misi.index', [
            'desa' => $desa,
            'visi' => $desa->visiMisi()->where('jenis', 'visi')->orderBy('urutan')->first(),
            'misi' => $desa->visiMisi()->where('jenis', 'misi')->orderBy('urutan')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $desa = $this->authorizeManage($request);

        $data = $request->validate([
            'jenis' => ['required', 'string', 'in:visi,misi'],
            'isi' => ['required', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['urutan'] ??= 0;

        $desa->visiMisi()->create($data);

        return redirect()->route('admin.visi-misi.index')->with('status', 'Visi/misi berhasil ditambahkan.');
    }

    public function edit(Request $request, VisiMisi $visiMisi): View
    {
        $desa = $this->currentDesa($request);
        abort_unless($visiMisi->desa_id === $desa->id, 404);

        return view('admin.visi-misi.edit', compact('desa', 'visiMisi'));
    }

    public function update(Request $request, VisiMisi $visiMisi): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($visiMisi->desa_id === $desa->id, 404);

        $data = $request->validate([
            'jenis' => ['required', 'string', 'in:visi,misi'],
            'isi' => ['required', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['urutan'] ??= 0;

        $visiMisi->update($data);

        return redirect()->route('admin.visi-misi.index')->with('status', 'Visi/misi berhasil diperbarui.');
    }

    public function destroy(Request $request, VisiMisi $visiMisi): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($visiMisi->desa_id === $desa->id, 404);

        $visiMisi->delete();

        return redirect()->route('admin.visi-misi.index')->with('status', 'Visi/misi berhasil dihapus.');
    }
}
