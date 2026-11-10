<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\SejarahDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SejarahDesaController extends Controller
{
    public function index(Desa $desa): JsonResponse
    {
        return response()->json(
            $desa->sejarah()->orderBy('urutan')->get()
        );
    }

    public function store(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

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

        $sejarah = $desa->sejarah()->create($data);

        return response()->json($sejarah, 201);
    }

    public function show(Desa $desa, SejarahDesa $sejarah): JsonResponse
    {
        return response()->json($sejarah);
    }

    public function update(Request $request, Desa $desa, SejarahDesa $sejarah): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'judul' => ['sometimes', 'string', 'max:255'],
            'isi' => ['sometimes', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'urutan' => ['sometimes', 'integer', 'min:0'],
        ]);

        if ($request->hasFile('foto')) {
            if ($sejarah->foto_path) {
                Storage::disk('public')->delete($sejarah->foto_path);
            }

            $data['foto_path'] = $request->file('foto')->store('sejarah-desa', 'public');
        }

        unset($data['foto']);

        $sejarah->update($data);

        return response()->json($sejarah);
    }

    public function destroy(Desa $desa, SejarahDesa $sejarah): Response
    {
        $this->authorize('manage-desa', $desa);

        if ($sejarah->foto_path) {
            Storage::disk('public')->delete($sejarah->foto_path);
        }

        $sejarah->delete();

        return response()->noContent();
    }
}
