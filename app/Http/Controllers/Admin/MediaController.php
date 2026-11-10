<?php

namespace App\Http\Controllers\Admin;

use App\Models\MediaDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends AdminController
{
    public function index(Request $request): View
    {
        $desa = $this->currentDesa($request);

        return view('admin.media.index', [
            'desa' => $desa,
            'items' => $desa->media()->latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $desa = $this->authorizeManage($request);

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'in:foto,video,dokumen'],
            'keterangan' => ['nullable', 'string'],
            'file' => ['required', 'file', 'max:10240'],
        ]);

        $data['file_path'] = $request->file('file')->store('media-desa', 'public');
        unset($data['file']);

        $desa->media()->create($data);

        return redirect()->route('admin.media.index')->with('status', 'Media berhasil diunggah.');
    }

    public function destroy(Request $request, MediaDesa $media): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($media->desa_id === $desa->id, 404);

        if ($media->file_path) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();

        return redirect()->route('admin.media.index')->with('status', 'Media berhasil dihapus.');
    }
}
