@extends('layouts.admin')

@section('title', 'Edit Statistik {{ $statistik->tahun }} — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Edit Statistik {{ $statistik->tahun }}</h1>
            <p>Mengubah data kependudukan tahun {{ $statistik->tahun }} pada {{ $desa->nama_desa }}.</p>
        </div>
        <a href="{{ route('admin.statistik.index') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Daftar</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-form-section">
        <h2 class="admin-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Perbarui Data {{ $statistik->tahun }}
        </h2>

        <form method="POST" action="{{ route('admin.statistik.update', $statistik) }}">
            @csrf
            @method('PUT')

            <div class="admin-form-grid">
                <div class="admin-form-group" style="max-width:180px;">
                    <label class="admin-form-label" for="tahun">Tahun</label>
                    <input class="admin-form-control" type="number" id="tahun" name="tahun"
                           value="{{ old('tahun', $statistik->tahun) }}" min="1901" max="2155" required>
                </div>

                <div class="admin-form-row-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="jumlah_penduduk">Jumlah Penduduk</label>
                        <input class="admin-form-control" type="number" id="jumlah_penduduk" name="jumlah_penduduk"
                               value="{{ old('jumlah_penduduk', $statistik->jumlah_penduduk) }}" min="0" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="jumlah_kk">Kepala Keluarga</label>
                        <input class="admin-form-control" type="number" id="jumlah_kk" name="jumlah_kk"
                               value="{{ old('jumlah_kk', $statistik->jumlah_kk) }}" min="0" required>
                    </div>
                </div>

                <div class="admin-form-row-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="laki_laki">Laki-laki</label>
                        <input class="admin-form-control" type="number" id="laki_laki" name="laki_laki"
                               value="{{ old('laki_laki', $statistik->laki_laki) }}" min="0" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="perempuan">Perempuan</label>
                        <input class="admin-form-control" type="number" id="perempuan" name="perempuan"
                               value="{{ old('perempuan', $statistik->perempuan) }}" min="0" required>
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="jumlah_dusun">Jumlah Dusun</label>
                    <input class="admin-form-control" type="number" id="jumlah_dusun" name="jumlah_dusun"
                           value="{{ old('jumlah_dusun', $statistik->jumlah_dusun) }}" min="0" required>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn-admin-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;margin-right:6px;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.statistik.index') }}" class="btn-admin-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
