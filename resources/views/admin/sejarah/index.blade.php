@extends('layouts.admin')

@section('title', 'Sejarah Desa — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Sejarah Desa</h1>
            <p>Linimasa sejarah dan asal-usul {{ $desa->nama_desa }}.</p>
        </div>
        <a href="{{ route('admin.sejarah.create') }}" class="btn-admin-primary btn-admin-sm">+ Tambah Entri</a>
        <a href="{{ route('admin.dashboard') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Dashboard</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:60px;">Urutan</th>
                    <th>Judul</th>
                    <th style="width:120px;">Foto</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td><span class="admin-badge">{{ $item->urutan }}</span></td>
                        <td class="cell-wrap">{{ $item->judul }}</td>
                        <td>
                            @if ($item->foto_path)
                                <img src="{{ Storage::url($item->foto_path) }}" alt="Foto" class="admin-form-preview" style="width:60px;height:60px;">
                            @else
                                <span class="admin-badge admin-badge-abu">—</span>
                            @endif
                        </td>
                        <td class="admin-table-actions">
                            <a href="{{ route('admin.sejarah.edit', $item) }}" class="btn-admin-ghost btn-admin-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.sejarah.destroy', $item) }}" onsubmit="return confirm('Yakin ingin menghapus entri sejarah ini?')">
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
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/></svg>
                            </div>
                            <strong>Belum ada entri sejarah</div>
                            <p class="admin-form-hint" style="margin-top:8px;">Mulai dengan menambahkan entri sejarah pertama.</p>
                            <div class="admin-form-actions" style="justify-content:center; margin-top:14px;">
                                <a href="{{ route('admin.sejarah.create') }}" class="btn-admin-primary">+ Tambah Entri Sejarah</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
