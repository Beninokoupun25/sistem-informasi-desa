@extends('layouts.admin')

@section('title', 'Visi & Misi — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Visi &amp; Misi</h1>
            <p>Visi dan setiap butir misi {{ $desa->nama_desa }} — disimpan terpisah agar mudah dikelola.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Dashboard</a>
    </div>

    @include('admin.partials.errors')

    {{-- Visi --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-section-title" style="margin:0;">Visi Desa</h2>
                <p style="margin:4px 0 0; font-size:12.5px; color:var(--teks-lembut);">Satu rumusan visi utama desa.</p>
            </div>
            @if ($visi)
                <span class="admin-badge">1 visi tersimpan</span>
            @else
                <span class="admin-badge admin-badge-abu">Belum diisi</span>
            @endif
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ $visi ? route('admin.visi-misi.update', $visi) : route('admin.visi-misi.store') }}">
                @csrf
                @if ($visi)
                    @method('PUT')
                @endif
                <input type="hidden" name="jenis" value="visi">
                <input type="hidden" name="urutan" value="{{ $visi->urutan ?? 1 }}">

                <div class="admin-form-group">
                    <label class="admin-form-label" for="isi-visi">Rumusan Visi</label>
                    <textarea class="admin-form-control" id="isi-visi" name="isi" rows="4"
                              required>{{ old('isi', $visi->isi ?? '') }}</textarea>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="btn-admin-primary">{{ $visi ? 'Simpan Visi' : 'Simpan Visi' }}</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Misi --}}
    <div class="admin-card" style="margin-top: 18px;">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-section-title" style="margin:0;">Butir Misi</h2>
                <p style="margin:4px 0 0; font-size:12.5px; color:var(--teks-lembut);">{{ $misi->count() }} butir misi tersimpan.</p>
            </div>
        </div>
        <div class="admin-card-body">
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width:60px;">Urutan</th>
                            <th>Isi Misi</th>
                            <th style="width:160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($misi as $item)
                            <tr>
                                <td><span class="admin-badge">{{ $item->urutan }}</span></td>
                                <td class="cell-wrap">{{ $item->isi }}</td>
                                <td class="admin-table-actions">
                                    <a href="{{ route('admin.visi-misi.edit', $item) }}" class="btn-admin-ghost btn-admin-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.visi-misi.destroy', $item) }}" onsubmit="return confirm('Yakin ingin menghapus butir misi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-admin-danger btn-admin-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="admin-empty" style="padding:30px 20px; border:0;">
                                    <div class="icon" style="width:40px;height:40px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/></svg>
                                    </div>
                                    <strong>Belum ada butir misi</strong>
                                    <p class="admin-form-hint" style="margin-top:8px;">Tambahkan butir misi pertama di bawah.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <form method="POST" action="{{ route('admin.visi-misi.store') }}" class="admin-form-section" style="padding:20px; margin-top:16px;">
                @csrf
                <input type="hidden" name="jenis" value="misi">

                <div class="admin-form-row-2">
                    <div class="admin-form-group" style="flex:1;">
                        <label class="admin-form-label" for="isi-misi">Tambah Butir Misi</label>
                        <input class="admin-form-control" type="text" id="isi-misi" name="isi"
                               value="{{ old('isi') }}" required maxlength="1000"
                               placeholder="Contoh: Meningkatkan pelayanan publik…">
                    </div>
                    <div class="admin-form-group" style="max-width:150px;">
                        <label class="admin-form-label" for="urutan-misi">Urutan</label>
                        <input class="admin-form-control" type="number" id="urutan-misi" name="urutan"
                               value="{{ old('urutan', $misi->count() + 1) }}" min="0">
                    </div>
                </div>

                <div class="admin-form-actions" style="margin-top:14px;">
                    <button type="submit" class="btn-admin-primary">+ Tambah Butir</button>
                </div>
            </form>
        </div>
    </div>
@endsection
