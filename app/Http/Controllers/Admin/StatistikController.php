<?php

namespace App\Http\Controllers\Admin;

use App\Models\StatistikDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StatistikController extends AdminController
{
    public function index(Request $request): View
    {
        $desa = $this->currentDesa($request);

        return view('admin.statistik.index', [
            'desa' => $desa,
            'items' => $desa->statistik()->orderByDesc('tahun')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.statistik.create', ['desa' => $this->currentDesa($request)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $desa = $this->authorizeManage($request);

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

        $desa->statistik()->create($data);

        return redirect()->route('admin.statistik.index')->with('status', 'Statistik berhasil ditambahkan.');
    }

    public function edit(Request $request, StatistikDesa $statistik): View
    {
        $desa = $this->currentDesa($request);
        abort_unless($statistik->desa_id === $desa->id, 404);

        return view('admin.statistik.edit', compact('desa', 'statistik'));
    }

    public function update(Request $request, StatistikDesa $statistik): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($statistik->desa_id === $desa->id, 404);

        $data = $request->validate([
            'tahun' => [
                'required', 'integer', 'min:1901', 'max:2155',
                Rule::unique('statistik_desa', 'tahun')
                    ->where('desa_id', $desa->id)
                    ->ignore($statistik),
            ],
            'jumlah_penduduk' => ['required', 'integer', 'min:0'],
            'laki_laki' => ['required', 'integer', 'min:0'],
            'perempuan' => ['required', 'integer', 'min:0'],
            'jumlah_kk' => ['required', 'integer', 'min:0'],
            'jumlah_dusun' => ['required', 'integer', 'min:0'],
        ]);

        $statistik->update($data);

        return redirect()->route('admin.statistik.index')->with('status', 'Statistik berhasil diperbarui.');
    }

    public function destroy(Request $request, StatistikDesa $statistik): RedirectResponse
    {
        $desa = $this->authorizeManage($request);
        abort_unless($statistik->desa_id === $desa->id, 404);

        $statistik->delete();

        return redirect()->route('admin.statistik.index')->with('status', 'Statistik berhasil dihapus.');
    }
}
