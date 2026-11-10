<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\WilayahDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class WilayahDesaController extends Controller
{
    public function index(Desa $desa): JsonResponse
    {
        return response()->json(
            $desa->wilayah()->orderBy('id')->get()
        );
    }

    public function store(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'luas_wilayah' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'batas_utara' => ['nullable', 'string', 'max:255'],
            'batas_selatan' => ['nullable', 'string', 'max:255'],
            'batas_timur' => ['nullable', 'string', 'max:255'],
            'batas_barat' => ['nullable', 'string', 'max:255'],
            'geojson' => ['nullable', 'file', 'max:5120', 'mimes:json,geojson'],
        ]);

        if ($request->hasFile('geojson')) {
            $data['geojson_path'] = $request->file('geojson')->store('wilayah-desa', 'public');
        }

        unset($data['geojson']);

        $wilayah = $desa->wilayah()->create($data);

        return response()->json($wilayah, 201);
    }

    public function show(Desa $desa, WilayahDesa $wilayah): JsonResponse
    {
        return response()->json($wilayah);
    }

    public function update(Request $request, Desa $desa, WilayahDesa $wilayah): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'luas_wilayah' => ['sometimes', 'nullable', 'string', 'max:255'],
            'latitude' => ['sometimes', 'nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'nullable', 'numeric', 'between:-180,180'],
            'batas_utara' => ['sometimes', 'nullable', 'string', 'max:255'],
            'batas_selatan' => ['sometimes', 'nullable', 'string', 'max:255'],
            'batas_timur' => ['sometimes', 'nullable', 'string', 'max:255'],
            'batas_barat' => ['sometimes', 'nullable', 'string', 'max:255'],
            'geojson' => ['nullable', 'file', 'max:5120', 'mimes:json,geojson'],
        ]);

        if ($request->hasFile('geojson')) {
            if ($wilayah->geojson_path) {
                Storage::disk('public')->delete($wilayah->geojson_path);
            }

            $data['geojson_path'] = $request->file('geojson')->store('wilayah-desa', 'public');
        }

        unset($data['geojson']);

        $wilayah->update($data);

        return response()->json($wilayah);
    }

    public function destroy(Desa $desa, WilayahDesa $wilayah): Response
    {
        $this->authorize('manage-desa', $desa);

        if ($wilayah->geojson_path) {
            Storage::disk('public')->delete($wilayah->geojson_path);
        }

        $wilayah->delete();

        return response()->noContent();
    }
}
