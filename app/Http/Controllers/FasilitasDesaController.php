<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\FasilitasDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class FasilitasDesaController extends Controller
{
    public function index(Desa $desa): JsonResponse
    {
        return response()->json(
            $desa->fasilitas()->orderBy('nama')->get()
        );
    }

    public function store(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $request->file('foto')->store('fasilitas-desa', 'public');
        }

        unset($data['foto']);

        $fasilitas = $desa->fasilitas()->create($data);

        return response()->json($fasilitas, 201);
    }

    public function show(Desa $desa, FasilitasDesa $fasilitas): JsonResponse
    {
        return response()->json($fasilitas);
    }

    public function update(Request $request, Desa $desa, FasilitasDesa $fasilitas): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'nama' => ['sometimes', 'string', 'max:255'],
            'kategori' => ['sometimes', 'string', 'max:255'],
            'alamat' => ['sometimes', 'nullable', 'string', 'max:255'],
            'latitude' => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
            'deskripsi' => ['sometimes', 'nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($fasilitas->foto_path) {
                Storage::disk('public')->delete($fasilitas->foto_path);
            }

            $data['foto_path'] = $request->file('foto')->store('fasilitas-desa', 'public');
        }

        unset($data['foto']);

        $fasilitas->update($data);

        return response()->json($fasilitas);
    }

    public function destroy(Desa $desa, FasilitasDesa $fasilitas): Response
    {
        $this->authorize('manage-desa', $desa);

        if ($fasilitas->foto_path) {
            Storage::disk('public')->delete($fasilitas->foto_path);
        }

        $fasilitas->delete();

        return response()->noContent();
    }
}
