@extends('layouts.admin')

@section('title', 'Fasilitas Desa — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Fasilitas Desa</h1>
            <p>Fasilitas publik di {{ $desa->nama_desa }} dengan lokasi untuk peta.</p>
        </div>
        <a href="{{ route('admin.fasilitas.create') }}" class="btn-admin-primary btn-admin-sm">+ Tambah Fasilitas</a>
        <a href="{{ route('admin.dashboard') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Dashboard</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th style="width:140px;">Kategori</th>
                    <th style="width:160px;">Alamat</th>
                    <th style="width:150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td class="cell-wrap">{{ $item->nama }}</td>
                        <td><span class="admin-badge">{{ $item->kategori }}</span></td>
                        <td class="cell-wrap">{{ $item->alamat ?? '—' }}</td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.fasilitas.edit', $item) }}" class="btn-admin-ghost btn-admin-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.fasilitas.destroy', $item) }}" onsubmit="return confirm('Yakin ingin menghapus fasilitas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-danger btn-admin-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="admin-empty" style="padding:40px 20px; border:0;">
                            <div class="icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                            <strong>Belum ada fasilitas</strong>
                            <p class="admin-form-hint" style="margin-top:8px;">Mulai dengan menambahkan fasilitas pertama.</p>
                            <div class="admin-form-actions" style="justify-content:center; margin-top:14px;">
                                <a href="{{ route('admin.fasilitas.create') }}" class="btn-admin-primary">+ Tambah Fasilitas</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
