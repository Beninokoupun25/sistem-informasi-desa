@extends('layouts.admin')

@section('title', 'Statistik Desa — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Statistik Desa</h1>
            <p>Data kependudukan {{ $desa->nama_desa }} per tahun.</p>
        </div>
        <a href="{{ route('admin.statistik.create') }}" class="btn-admin-primary btn-admin-sm">+ Tambah Data</a>
        <a href="{{ route('admin.dashboard') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Dashboard</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:90px;">Tahun</th>
                    <th style="width:130px;">Penduduk</th>
                    <th style="width:110px;">Laki-laki</th>
                    <th style="width:110px;">Perempuan</th>
                    <th style="width:100px;">KK</th>
                    <th style="width:100px;">Dusun</th>
                    <th style="width:150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td><strong>{{ $item->tahun }}</strong></td>
                        <td>{{ number_format($item->jumlah_penduduk, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->laki_laki, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->perempuan, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->jumlah_kk, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->jumlah_dusun, 0, ',', '.') }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.statistik.edit', $item) }}" class="btn-admin-ghost btn-admin-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.statistik.destroy', $item) }}" onsubmit="return confirm('Yakin ingin menghapus data tahun {{ $item->tahun }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-danger btn-admin-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="admin-empty" style="padding:40px 20px; border:0;">
                            <div class="icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </div>
                            <strong>Belum ada data statistik</strong>
                            <p class="admin-form-hint" style="margin-top:8px;">Mulai dengan menambahkan data kependudukan pertama.</p>
                            <div class="admin-form-actions" style="justify-content:center; margin-top:14px;">
                                <a href="{{ route('admin.statistik.create') }}" class="btn-admin-primary">+ Tambah Data Statistik</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
