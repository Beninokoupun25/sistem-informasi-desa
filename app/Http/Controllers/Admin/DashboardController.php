<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends AdminController
{
    public function index(Request $request): View
    {
        $desa = $this->currentDesa($request);

        $semuaDesa = $this->semuaDesaAktif();

        return view('admin.dashboard', [
            'desa' => $desa,
            'semuaDesa' => $semuaDesa,
            'statistikTerbaru' => $desa->statistik()->orderByDesc('tahun')->first(),
            'jumlahSejarah' => $desa->sejarah()->count(),
            'jumlahVisiMisi' => $desa->visiMisi()->count(),
            'jumlahPerangkat' => $desa->perangkat()->count(),
            'jumlahStatistik' => $desa->statistik()->count(),
            'jumlahFasilitas' => $desa->fasilitas()->count(),
            'jumlahMedia' => $desa->media()->count(),
            'jumlahWilayah' => $desa->wilayah()->count(),
        ]);
    }

    public function pilihDesa(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'slug' => ['required', 'string'],
        ]);

        $desa = \App\Models\Desa::where('status', 'aktif')->where('slug', $data['slug'])->firstOrFail();

        $request->session()->put('admin_desa_slug', $desa->slug);

        return back()->with('status', 'Desa aktif diganti ke '.$desa->nama_desa.'.');
    }
}
