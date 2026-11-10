<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    private function desa(): Desa
    {
        $desa = Desa::where('status', 'aktif')
            ->where('slug', session('desa_slug'))
            ->first();

        if (! $desa) {
            $desa = Desa::where('status', 'aktif')
                ->orderBy('id')
                ->firstOrFail();

            session(['desa_slug' => $desa->slug]);
        }

        return $desa;
    }

    public function pilihDesa(Request $request)
    {
        $desa = Desa::where('status', 'aktif')
            ->where('slug', $request->input('slug'))
            ->firstOrFail();

        session(['desa_slug' => $desa->slug]);

        $kembali = $request->input('kembali');

        if ($kembali && Str::startsWith($kembali, $request->getSchemeAndHttpHost())) {
            return redirect()->to($kembali);
        }

        return redirect()->route('beranda');
    }

    public function selamatDatang()
    {
        $desa = $this->desa()->load('profil');

        return view('pages.selamat-datang', [
            'desa' => $desa,
        ]);
    }

    public function beranda()
    {
        $desa = $this->desa()->load(['profil', 'visiMisi', 'statistik', 'fasilitas', 'sejarah']);

        return view('pages.beranda', [
            'desa' => $desa,
            'visi' => $desa->visiMisi->firstWhere('jenis', 'visi'),
            'misi' => $desa->visiMisi->where('jenis', 'misi')->sortBy('urutan'),
            'statistikTerbaru' => $desa->statistik->sortByDesc('tahun')->first(),
            'fasilitasUnggulan' => $desa->fasilitas->take(3),
        ]);
    }

    public function sejarah()
    {
        $desa = $this->desa();

        return view('pages.sejarah', [
            'desa' => $desa,
            'sejarah' => $desa->sejarah()->orderBy('urutan')->get(),
        ]);
    }

    public function visiMisi()
    {
        $desa = $this->desa();

        return view('pages.visi-misi', [
            'desa' => $desa,
            'visi' => $desa->visiMisi()->where('jenis', 'visi')->orderBy('urutan')->get(),
            'misi' => $desa->visiMisi()->where('jenis', 'misi')->orderBy('urutan')->get(),
        ]);
    }

    public function wilayah()
    {
        $desa = $this->desa();

        $wilayah = $desa->wilayah()->orderBy('id')->get()->map(function ($item) {
            $item->geojson_data = $item->geojson_path && Storage::disk('public')->exists($item->geojson_path)
                ? json_decode(Storage::disk('public')->get($item->geojson_path), true)
                : null;

            return $item;
        });

        return view('pages.wilayah', [
            'desa' => $desa,
            'wilayah' => $wilayah,
        ]);
    }

    public function perangkat()
    {
        $desa = $this->desa();

        return view('pages.perangkat', [
            'desa' => $desa,
            'perangkat' => $desa->perangkat()->orderBy('urutan')->get(),
        ]);
    }

    public function statistik()
    {
        $desa = $this->desa();

        return view('pages.statistik', [
            'desa' => $desa,
            'statistik' => $desa->statistik()->orderByDesc('tahun')->get(),
        ]);
    }

    public function fasilitas()
    {
        $desa = $this->desa();

        return view('pages.fasilitas', [
            'desa' => $desa,
            'fasilitas' => $desa->fasilitas()->orderBy('nama')->get(),
        ]);
    }

    public function media()
    {
        $desa = $this->desa();

        return view('pages.media', [
            'desa' => $desa,
            'media' => $desa->media()->latest()->get(),
        ]);
    }
}
