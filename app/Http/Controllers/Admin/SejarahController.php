<?php

namespace App\Http\Controllers\Admin;

use App\Models\SejarahDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SejarahController extends AdminController
{
    public function index(Request $request): View
    {
        $desa = $this->currentDesa($request);

        return view('admin.sejarah.index', [
            'desa' => $desa,
            'items' => $desa->sejarah()->orderBy('urutan')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.sejarah.create', ['desa' => $this->currentDesa($request)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $desa = $this->authorizeManage($request);

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('sejarah-desa', 'public');
        }

        unset($data['foto']);
        $data['urutan'] ??= 0;

        $desa->sejarah()->create($data);

        return redirect()->route('admin.sejarah.index')->with('status', 'Sejarah berhasil ditambahkan.');
    }

    public function edit(Request $request, SejarahDesa $sejarah): View
    {
        $desa = $this->currentDesa($request);
        abort_unless($sejarah->desa_id === $desa->id, 404);

        return view('admin.sejarah.edit', compact('desa', 'sejarah'));
    }

    public function update(Request $request, SejarahDesa $sejarah): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($sejarah->desa_id === $desa->id, 404);

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('foto')) {
            if ($sejarah->foto_path) {
                Storage::disk('public')->delete($sejarah->foto_path);
            }

            $data['foto_path'] = $request->file('foto')->store('sejarah-desa', 'public');
        }

        unset($data['foto']);
        $data['urutan'] ??= 0;

        $sejarah->update($data);

        return redirect()->route('admin.sejarah.index')->with('status', 'Sejarah berhasil diperbarui.');
    }

    public function destroy(Request $request, SejarahDesa $sejarah): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($sejarah->desa_id === $desa->id, 404);

        if ($sejarah->foto_path) {
            Storage::disk('public')->delete($sejarah->foto_path);
        }

        $sejarah->delete();

        return redirect()->route('admin.sejarah.index')->with('status', 'Sejarah berhasil dihapus.');
    }
}
