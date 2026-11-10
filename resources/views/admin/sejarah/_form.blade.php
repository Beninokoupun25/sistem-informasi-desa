<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="judul">Judul</label>
        <input class="form-control" type="text" id="judul" name="judul" value="{{ old('judul', $item->judul ?? '') }}" required maxlength="255">
    </div>
    <div class="form-group">
        <label class="form-label" for="isi">Isi</label>
        <textarea class="form-control" id="isi" name="isi" rows="8" required>{{ old('isi', $item->isi ?? '') }}</textarea>
    </div>
    <div class="form-row-2">
        <div class="form-group">
            <label class="form-label" for="urutan">Urutan</label>
            <input class="form-control" type="number" id="urutan" name="urutan" value="{{ old('urutan', $item->urutan ?? 0) }}" min="0">
        </div>
        <div class="form-group">
            <label class="form-label" for="foto">Foto (opsional)</label>
            @if (! empty($item?->foto_path))
                <img src="{{ Storage::url($item->foto_path) }}" alt="Foto saat ini" class="form-preview form-preview--wide">
            @endif
            <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
        </div>
    </div>
</div>
