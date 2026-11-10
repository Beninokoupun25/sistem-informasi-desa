<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\StatistikDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class StatistikDesaController extends Controller
{
    public function index(Desa $desa): JsonResponse
    {
        return response()->json(
            $desa->statistik()->orderByDesc('tahun')->get()
        );
    }

    public function store(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'tahun' => [
                'required', 'integer', 'min:1901', 'max:2155',
                Rule::unique('statistik_desa', 'tahun')->where('desa_id', $desa->id),
            ],
            'jumlah_penduduk' => ['required', 'integer', 'min:0'],
            'laki_laki' => ['required', 'integer', 'min:0'],
            'perempuan' => ['required', 'integer', 'min:0'],
            'jumlah_kk' => ['required', 'integer', 'min:0'],
            'jumlah_dusun' => ['required', 'integer', 'min:0'],
        ]);

        $statistik = $desa->statistik()->create($data);

        return response()->json($statistik, 201);
    }

    public function show(Desa $desa, StatistikDesa $statistik): JsonResponse
    {
        return response()->json($statistik);
    }

    public function update(Request $request, Desa $desa, StatistikDesa $statistik): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'tahun' => [
                'sometimes', 'integer', 'min:1901', 'max:2155',
                Rule::unique('statistik_desa', 'tahun')
                    ->where('desa_id', $desa->id)
                    ->ignore($statistik),
            ],
            'jumlah_penduduk' => ['sometimes', 'integer', 'min:0'],
            'laki_laki' => ['sometimes', 'integer', 'min:0'],
            'perempuan' => ['sometimes', 'integer', 'min:0'],
            'jumlah_kk' => ['sometimes', 'integer', 'min:0'],
            'jumlah_dusun' => ['sometimes', 'integer', 'min:0'],
        ]);

        $statistik->update($data);

        return response()->json($statistik);
    }

    public function destroy(Desa $desa, StatistikDesa $statistik): Response
    {
        $this->authorize('manage-desa', $desa);

        $statistik->delete();

        return response()->noContent();
    }
}
