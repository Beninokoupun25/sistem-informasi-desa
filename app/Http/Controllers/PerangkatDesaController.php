<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\PerangkatDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PerangkatDesaController extends Controller
{
    public function index(Desa $desa): JsonResponse
    {
        return response()->json(
            $desa->perangkat()->orderBy('urutan')->get()
        );
    }

    public function store(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'kontak' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'status' => ['nullable', 'string', 'in:aktif,nonaktif'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        unset($data['foto']);
        $data['urutan'] ??= 0;
        $data['status'] ??= 'aktif';

        $perangkat = $desa->perangkat()->create($data);

        return response()->json($perangkat, 201);
    }

    public function show(Desa $desa, PerangkatDesa $perangkat): JsonResponse
    {
        return response()->json($perangkat);
    }

    public function update(Request $request, Desa $desa, PerangkatDesa $perangkat): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'nama' => ['sometimes', 'string', 'max:255'],
            'jabatan' => ['sometimes', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'kontak' => ['nullable', 'string', 'max:255'],
            'urutan' => ['sometimes', 'integer', 'min:0'],
            'status' => ['sometimes', 'string', 'in:aktif,nonaktif'],
        ]);

        if ($request->hasFile('foto')) {
            if ($perangkat->foto_path) {
                Storage::disk('public')->delete($perangkat->foto_path);
            }

            $data['foto_path'] = $request->file('foto')->store('perangkat-desa', 'public');
        }

        unset($data['foto']);

        $perangkat->update($data);

        return response()->json($perangkat);
    }

    public function destroy(Desa $desa, PerangkatDesa $perangkat): Response
    {
        $this->authorize('manage-desa', $desa);

        if ($perangkat->foto_path) {
            Storage::disk('public')->delete($perangkat->foto_path);
        }

        $perangkat->delete();

        return response()->noContent();
    }
}
