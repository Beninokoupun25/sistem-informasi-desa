<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfilController extends AdminController
{
    public function edit(Request $request): View
    {
        $desa = $this->currentDesa($request)->load('profil');

        return view('admin.profil.edit', [
            'desa' => $desa,
            'profil' => $desa->profil,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $desa = $this->authorizeManage($request);

        $data = $request->validate([
            'alamat' => ['required', 'string', 'max:255'],
            'telepon' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            if ($desa->profil?->logo_path) {
                Storage::disk('public')->delete($desa->profil->logo_path);
            }

            $data['logo_path'] = $request->file('logo')->store('logo-desa', 'public');
        }

        unset($data['logo']);

        $desa->profil()->updateOrCreate([], $data);

        return back()->with('status', 'Profil desa berhasil disimpan.');
    }
}
