<?php

namespace App\Http\Controllers\Admin;

use App\Models\FasilitasDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FasilitasController extends AdminController
{
    public function index(Request $request): View
    {
        $desa = $this->currentDesa($request);

        return view('admin.fasilitas.index', [
            'desa' => $desa,
            'items' => $desa->fasilitas()->orderBy('nama')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.fasilitas.create', ['desa' => $this->currentDesa($request)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $desa = $this->authorizeManage($request);

        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('fasilitas-desa', 'public');
        }

        unset($data['foto']);

        $desa->fasilitas()->create($data);

        return redirect()->route('admin.fasilitas.index')->with('status', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Request $request, FasilitasDesa $fasilitas): View
    {
        $desa = $this->currentDesa($request);
        abort_unless($fasilitas->desa_id === $desa->id, 404);

        return view('admin.fasilitas.edit', compact('desa', 'fasilitas'));
    }

    public function update(Request $request, FasilitasDesa $fasilitas): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($fasilitas->desa_id === $desa->id, 404);

        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            if ($fasilitas->foto_path) {
                Storage::disk('public')->delete($fasilitas->foto_path);
            }

            $data['foto_path'] = $request->file('foto')->store('fasilitas-desa', 'public');
        }

        unset($data['foto']);

        $fasilitas->update($data);

        return redirect()->route('admin.fasilitas.index')->with('status', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Request $request, FasilitasDesa $fasilitas): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($fasilitas->desa_id === $desa->id, 404);

        if ($fasilitas->foto_path) {
            Storage::disk('public')->delete($fasilitas->foto_path);
        }

        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')->with('status', 'Fasilitas berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
