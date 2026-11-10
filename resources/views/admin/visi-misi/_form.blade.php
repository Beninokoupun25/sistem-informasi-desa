<input type="hidden" name="jenis" value="{{ old('jenis', $item->jenis ?? 'misi') }}">

<div class="admin-form-grid">
    <div class="admin-form-group">
        <label class="admin-form-label" for="isi">{{ strtoupper(old('jenis', $item->jenis ?? 'misi')) }}</label>
        <textarea class="admin-form-control" id="isi" name="isi" rows="4" required>{{ old('isi', $item->isi ?? '') }}</textarea>
    </div>
    <div class="admin-form-group" style="max-width: 180px;">
        <label class="admin-form-label" for="urutan">Urutan</label>
        <input class="admin-form-control" type="number" id="urutan" name="urutan"
               value="{{ old('urutan', $item->urutan ?? 0) }}" min="0">
    </div>
</div>
