<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\VisiMisi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VisiMisiController extends Controller
{
    public function index(Desa $desa): JsonResponse
    {
        return response()->json(
            $desa->visiMisi()->orderBy('urutan')->get()
        );
    }

    public function store(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'jenis' => ['required', 'string', 'in:visi,misi'],
            'isi' => ['required', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['urutan'] ??= 0;

        $visiMisi = $desa->visiMisi()->create($data);

        return response()->json($visiMisi, 201);
    }

    public function show(Desa $desa, VisiMisi $visiMisi): JsonResponse
    {
        return response()->json($visiMisi);
    }

    public function update(Request $request, Desa $desa, VisiMisi $visiMisi): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'jenis' => ['sometimes', 'string', 'in:visi,misi'],
            'isi' => ['sometimes', 'string'],
            'urutan' => ['sometimes', 'integer', 'min:0'],
        ]);

        $visiMisi->update($data);

        return response()->json($visiMisi);
    }

    public function destroy(Desa $desa, VisiMisi $visiMisi): Response
    {
        $this->authorize('manage-desa', $desa);

        $visiMisi->delete();

        return response()->noContent();
    }
}
