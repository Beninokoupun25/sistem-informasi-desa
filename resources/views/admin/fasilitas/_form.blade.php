<div class="admin-form-grid">
    <div class="admin-form-row-2">
        <div class="admin-form-group">
            <label class="admin-form-label" for="nama">Nama Fasilitas</label>
            <input class="admin-form-control" type="text" id="nama" name="nama"
                   value="{{ old('nama', $item->nama ?? '') }}" required maxlength="255">
        </div>
        <div class="admin-form-group">
            <label class="admin-form-label" for="kategori">Kategori</label>
            <input class="admin-form-control" type="text" id="kategori" name="kategori" list="kategori-list"
                   value="{{ old('kategori', $item->kategori ?? '') }}" required maxlength="255">
            <datalist id="kategori-list">
                <option value="Pendidikan"></option>
                <option value="Kesehatan"></option>
                <option value="Peribadatan"></option>
                <option value="Pemerintahan"></option>
                <option value="Ekonomi"></option>
                <option value="Olahraga"></option>
                <option value="Sosial Budaya"></option>
            </datalist>
        </div>
    </div>
    <div class="admin-form-group">
        <label class="admin-form-label" for="alamat">Alamat (Opsional)</label>
        <input class="admin-form-control" type="text" id="alamat" name="alamat"
               value="{{ old('alamat', $item->alamat ?? '') }}" maxlength="255">
    </div>
    <div class="admin-form-row-2">
        <div class="admin-form-group">
            <label class="admin-form-label" for="latitude">Latitude (Opsional)</label>
            <input class="admin-form-control" type="number" step="any" id="latitude" name="latitude"
                   value="{{ old('latitude', $item->latitude ?? '') }}" min="-90" max="90">
        </div>
        <div class="admin-form-group">
            <label class="admin-form-label" for="longitude">Longitude (Opsional)</label>
            <input class="admin-form-control" type="number" step="any" id="longitude" name="longitude"
                   value="{{ old('longitude', $item->longitude ?? '') }}" min="-180" max="180">
        </div>
    </div>
    <div class="admin-form-group">
        <label class="admin-form-label" for="deskripsi">Deskripsi (Opsional)</label>
        <textarea class="admin-form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
    </div>
    <div class="admin-form-group">
        <label class="admin-form-label" for="foto">Foto Fasilitas (Opsional)</label>

        <div style="margin-bottom: 10px;">
            @if (! empty($item?->foto_path))
                <img src="{{ Storage::url($item->foto_path) }}" alt="Foto saat ini" class="admin-form-preview form-preview--wide">
            @else
                <div class="admin-form-preview admin-media-placeholder" style="width:100%;height:150px;">
                    <span style="font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Belum ada foto</span>
                </div>
            @endif
        </div>

        <input class="admin-form-control" type="file" id="foto" name="foto" accept="image/*">
    </div>
</div>
