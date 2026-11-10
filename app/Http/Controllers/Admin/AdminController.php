<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\Request;

abstract class AdminController extends Controller
{
    protected function currentDesa(Request $request): Desa
    {
        // Role tunggal super_admin: semua desa bisa dikelola.
        // Pilihan desa disimpan di sesi (fallback: desa aktif pertama).
        $desa = Desa::where('status', 'aktif')
            ->where('slug', $request->session()->get('admin_desa_slug'))
            ->first();

        if (! $desa) {
            $desa = Desa::where('status', 'aktif')->orderBy('id')->firstOrFail();
        }

        $request->session()->put('admin_desa_slug', $desa->slug);

        return $desa;
    }

    protected function semuaDesaAktif()
    {
        return Desa::where('status', 'aktif')->orderBy('nama_desa')->get();
    }

    protected function authorizeManage(Request $request): Desa
    {
        $desa = $this->currentDesa($request);
        $this->authorize('manage-desa', $desa);

        return $desa;
    }

    protected function back(string $nama): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('admin.dashboard')
            ->with('status', $nama);
    }
}
