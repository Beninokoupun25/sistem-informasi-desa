<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class DesaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Desa::with('profil')->orderBy('nama_desa')->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create-desa');

        $data = $request->validate([
            'nama_desa' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:desa,slug'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kabupaten' => ['required', 'string', 'max:255'],
            'provinsi' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'in:aktif,nonaktif'],
        ]);

        $data['slug'] ??= Str::slug($data['nama_desa']);
        $data['status'] ??= 'aktif';

        $desa = Desa::create($data);

        return response()->json($desa->load('profil'), 201);
    }

    public function show(Desa $desa): JsonResponse
    {
        return response()->json($desa->load('profil'));
    }

    public function update(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'nama_desa' => ['sometimes', 'string', 'max:255'],
            'slug' => ['sometimes', 'nullable', 'string', 'max:255', 'unique:desa,slug,'.$desa->getKey()],
            'kecamatan' => ['sometimes', 'string', 'max:255'],
            'kabupaten' => ['sometimes', 'string', 'max:255'],
            'provinsi' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'string', 'in:aktif,nonaktif'],
        ]);

        $desa->update($data);

        return response()->json($desa->load('profil'));
    }

    public function destroy(Desa $desa): Response
    {
        $this->authorize('manage-desa', $desa);

        $desa->delete();

        return response()->noContent();
    }
}
