<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilDesaController extends Controller
{
    public function show(Desa $desa): JsonResponse
    {
        return response()->json($desa->profil);
    }

    public function update(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

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

        $profil = $desa->profil()->updateOrCreate([], $data);

        return response()->json($profil);
    }
}
