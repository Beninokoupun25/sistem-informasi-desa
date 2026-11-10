<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\MediaDesa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MediaDesaController extends Controller
{
    public function index(Desa $desa): JsonResponse
    {
        return response()->json(
            $desa->media()->latest()->get()
        );
    }

    public function store(Request $request, Desa $desa): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'in:foto,video,dokumen'],
            'keterangan' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:10240'],
        ]);

        $data['file_path'] = $request->file('file')->store('media-desa', 'public');
        unset($data['file']);

        $media = $desa->media()->create($data);

        return response()->json($media, 201);
    }

    public function show(Desa $desa, MediaDesa $media): JsonResponse
    {
        return response()->json($media);
    }

    public function update(Request $request, Desa $desa, MediaDesa $media): JsonResponse
    {
        $this->authorize('manage-desa', $desa);

        $data = $request->validate([
            'judul' => ['sometimes', 'string', 'max:255'],
            'jenis' => ['sometimes', 'string', 'in:foto,video,dokumen'],
            'keterangan' => ['sometimes', 'nullable', 'string'],
            'file' => ['nullable', 'file', 'max:10240'],
        ]);

        if ($request->hasFile('file')) {
            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }

            $data['file_path'] = $request->file('file')->store('media-desa', 'public');
        }

        unset($data['file']);

        $media->update($data);

        return response()->json($media);
    }

    public function destroy(Desa $desa, MediaDesa $media): Response
    {
        $this->authorize('manage-desa', $desa);

        if ($media->file_path) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return response()->noContent();
    }
}
