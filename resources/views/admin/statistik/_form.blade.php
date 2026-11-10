<div class="admin-form-grid">
    <div class="admin-form-group" style="max-width:180px;">
        <label class="admin-form-label" for="tahun">Tahun</label>
        <input class="admin-form-control" type="number" id="tahun" name="tahun"
               value="{{ old('tahun', $item->tahun ?? date('Y')) }}" min="1901" max="2155" required>
    </div>
    <div class="admin-form-row-2">
        <div class="admin-form-group">
            <label class="admin-form-label" for="jumlah_penduduk">Jumlah Penduduk</label>
            <input class="admin-form-control" type="number" id="jumlah_penduduk" name="jumlah_penduduk"
                   value="{{ old('jumlah_penduduk', $item->jumlah_penduduk ?? '') }}" min="0" required>
        </div>
        <div class="admin-form-group">
            <label class="admin-form-label" for="jumlah_kk">Kepala Keluarga</label>
            <input class="admin-form-control" type="number" id="jumlah_kk" name="jumlah_kk"
                   value="{{ old('jumlah_kk', $item->jumlah_kk ?? '') }}" min="0" required>
        </div>
    </div>
    <div class="admin-form-row-2">
        <div class="admin-form-group">
            <label class="admin-form-label" for="laki_laki">Laki-laki</label>
            <input class="admin-form-control" type="number" id="laki_laki" name="laki_laki"
                   value="{{ old('laki_laki', $item->laki_laki ?? '') }}" min="0" required>
        </div>
        <div class="admin-form-group">
            <label class="admin-form-label" for="perempuan">Perempuan</label>
            <input class="admin-form-control" type="number" id="perempuan" name="perempuan"
                   value="{{ old('perempuan', $item->perempuan ?? '') }}" min="0" required>
        </div>
    </div>
    <div class="admin-form-group">
        <label class="admin-form-label" for="jumlah_dusun">Jumlah Dusun</label>
        <input class="admin-form-control" type="number" id="jumlah_dusun" name="jumlah_dusun"
               value="{{ old('jumlah_dusun', $item->jumlah_dusun ?? '') }}" min="0" required>
    </div>
</div>
