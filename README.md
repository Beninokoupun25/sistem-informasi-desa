<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## sistem
🏡 Sistem Informasi Desa Digital
Modul Profil Desa — Rancangan ERD & Panduan Implementasi
📋 Deskripsi

Sistem Informasi Desa Digital adalah platform berbasis web yang dirancang untuk mengelola data dan profil desa secara digital. Dokumen ini mencakup rancangan Entity Relationship Diagram (ERD) untuk Modul Profil Desa, beserta panduan implementasi menggunakan framework Laravel.

Sistem ini dirancang untuk implementasi awal pada satu desa, namun struktur datanya sudah disiapkan untuk pengembangan ke banyak desa (multi-desa ready), dengan tabel desa sebagai entitas induk yang menghubungkan seluruh data konten melalui kolom desa_id.

Ruang lingkup: Dokumen ini berfokus pada ERD Modul Profil Desa dan konten pendukungnya. Modul layanan surat online, pengaduan, bantuan sosial, dan transaksi pelayanan berada di luar cakupan dokumen ini.

🗂️ Struktur Tabel Database
Ringkasan Entitas
Tabel	Fungsi	Relasi
desa	Data induk identitas desa	Induk semua tabel konten
profil_desa	Identitas, kontak, logo, dan deskripsi utama	1:1 dengan desa
sejarah_desa	Sejarah, asal-usul, dan dokumentasi sejarah	1:N dengan desa
visi_misi	Visi dan setiap butir misi desa	1:N dengan desa
wilayah_desa	Informasi geografis dan batas wilayah	1:N dengan desa
perangkat_desa	Data kepala desa dan perangkat pemerintahan	1:N dengan desa
statistik_desa	Statistik penduduk per tahun	1:N dengan desa
fasilitas_desa	Fasilitas umum dan titik lokasi pada peta	1:N dengan desa
pengguna	Akun super admin pengelola data	1:N dengan desa
media_desa	Galeri foto/video dan berkas publik desa	1:N dengan desa
🧩 Detail Atribut Tabel
desa

Entitas induk yang menjadi pusat relasi seluruh data konten.

Kolom	Keterangan
id	Primary Key
nama_desa	Nama resmi desa
slug	Slug URL desa
kecamatan	Nama kecamatan
kabupaten	Nama kabupaten/kota
provinsi	Nama provinsi
status	Status aktif/nonaktif desa
profil_desa

Menyimpan informasi kontak, logo, dan deskripsi utama desa.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id (UNIQUE)
alamat	Alamat kantor desa
telepon	Nomor telepon
email	Alamat email desa
logo_path	Path file logo desa
deskripsi	Deskripsi umum desa

Catatan: desa_id bersifat UNIQUE untuk memastikan relasi 1:1 — satu desa hanya memiliki satu profil utama.

sejarah_desa

Menyimpan konten sejarah dan asal-usul desa dalam beberapa bagian/seksi.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id
judul	Judul bagian sejarah
isi	Konten narasi sejarah
foto_path	Path foto dokumentasi
urutan	Urutan tampil konten
visi_misi

Menyimpan visi dan setiap butir misi sebagai baris terpisah agar mudah dikelola.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id
jenis	Enum: visi atau misi
isi	Teks visi atau butir misi
urutan	Urutan tampil
wilayah_desa

Menyimpan data geografis dan batas wilayah desa.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id
luas_wilayah	Luas wilayah desa
latitude	Koordinat lintang
longitude	Koordinat bujur
batas_utara	Batas wilayah utara
batas_selatan	Batas wilayah selatan
batas_timur	Batas wilayah timur
batas_barat	Batas wilayah barat
geojson_path	Path file GeoJSON batas wilayah
perangkat_desa

Data seluruh perangkat dan aparatur pemerintahan desa.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id
nama	Nama perangkat desa
jabatan	Jabatan/posisi
foto_path	Path foto perangkat
kontak	Nomor kontak
urutan	Urutan tampil
status	Status aktif/nonaktif
statistik_desa

Merekap data kependudukan desa berdasarkan tahun.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id
tahun	Tahun data statistik
jumlah_penduduk	Total jumlah penduduk
laki_laki	Jumlah penduduk laki-laki
perempuan	Jumlah penduduk perempuan
jumlah_kk	Jumlah kepala keluarga
jumlah_dusun	Jumlah dusun

Catatan: Constraint UNIQUE pada (desa_id, tahun) mencegah duplikasi rekap tahunan.

fasilitas_desa

Daftar fasilitas umum beserta koordinat lokasi untuk tampilan peta.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id
nama	Nama fasilitas
kategori	Kategori fasilitas (pendidikan, kesehatan, dll.)
alamat	Alamat fasilitas
latitude	Koordinat lintang
longitude	Koordinat bujur
deskripsi	Keterangan tambahan
foto_path	Path foto fasilitas
pengguna

Akun super admin (satu-satunya role) yang mengelola data semua desa.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id (nullable)
nama	Nama pengguna
email	Email login (UNIQUE)
password	Password (wajib di-hash)
role	Peran pengguna (satu-satunya: super_admin)
status	Status aktif/nonaktif
media_desa

Galeri foto, video, dan berkas publik milik desa.

Kolom	Keterangan
id	Primary Key
desa_id	Foreign Key → desa.id
judul	Judul media
file_path	Path file media
jenis	Jenis media (foto, video, dokumen)
keterangan	Keterangan tambahan
🔗 Diagram Relasi
DESA
 ├── 1:1 → profil_desa
 ├── 1:N → sejarah_desa
 ├── 1:N → visi_misi
 ├── 1:N → wilayah_desa
 ├── 1:N → perangkat_desa
 ├── 1:N → statistik_desa
 ├── 1:N → fasilitas_desa
 ├── 1:N → pengguna
 └── 1:N → media_desa
✅ Aturan Integritas Data
Aturan	Keterangan
Primary Key	Setiap tabel menggunakan kolom id sebagai identitas unik
Foreign Key	desa_id pada semua tabel konten mengacu ke desa.id
Profil unik	profil_desa.desa_id bersifat UNIQUE — satu desa, satu profil
Statistik tahunan	Constraint UNIQUE gabungan pada (desa_id, tahun)
Visi & Misi	Disimpan sebagai baris terpisah dengan kolom jenis dan urutan
Password	Wajib disimpan dalam bentuk hash, tidak pernah plain text
ON DELETE CASCADE	Terapkan secara hati-hati; pertimbangkan soft delete untuk data pemerintahan
Data pribadi	NIK dan dokumen pribadi tidak disimpan di tabel publik
⚙️ Panduan Implementasi Laravel
Model & Relasi Eloquent
php
// Desa.php
class Desa extends Model {
    public function profil()      { return $this->hasOne(ProfilDesa::class, 'desa_id'); }
    public function sejarah()     { return $this->hasMany(SejarahDesa::class, 'desa_id'); }
    public function visiMisi()    { return $this->hasMany(VisiMisi::class, 'desa_id'); }
    public function wilayah()     { return $this->hasMany(WilayahDesa::class, 'desa_id'); }
    public function perangkat()   { return $this->hasMany(PerangkatDesa::class, 'desa_id'); }
    public function statistik()   { return $this->hasMany(StatistikDesa::class, 'desa_id'); }
    public function fasilitas()   { return $this->hasMany(FasilitasDesa::class, 'desa_id'); }
    public function media()       { return $this->hasMany(MediaDesa::class, 'desa_id'); }
    public function pengguna()    { return $this->hasMany(Pengguna::class, 'desa_id'); }
}
Autentikasi (Laravel Breeze)

Gunakan tabel users bawaan Laravel Breeze sebagai pengganti tabel pengguna terpisah. Tambahkan kolom tambahan melalui migration:

php
// Migration tambahan untuk tabel users
Schema::table('users', function (Blueprint $table) {
    $table->foreignId('desa_id')->nullable()->constrained('desa');
    $table->string('role')->default('super_admin');
    $table->string('status')->default('aktif');
});
Penyimpanan File
php
// Simpan file ke Laravel Storage, bukan sebagai blob di database
$path = $request->file('foto')->store('perangkat', 'public');
// Simpan $path ke kolom foto_path
Query dengan Filter desa_id

Selalu sertakan filter desa_id pada setiap query data konten, meskipun saat ini hanya ada satu desa:

php
// Contoh: ambil perangkat desa berdasarkan desa_id
$perangkat = PerangkatDesa::where('desa_id', $desaId)
                          ->orderBy('urutan')
                          ->get();
Peta & Geospasial
Simpan latitude / longitude untuk titik lokasi fasilitas.
Simpan file GeoJSON ke Laravel Storage untuk batas wilayah desa.
Jangan menggambar batas wilayah berdasarkan perkiraan koordinat.
🔒 Catatan Keamanan
Password selalu di-hash menggunakan bcrypt atau argon2 (bawaan Laravel).
Semua pengguna adalah super admin (role tunggal) dan memiliki akses lintas desa; otorisasi hanya berdasar status aktif.
Data sensitif seperti NIK dan dokumen pribadi tidak disimpan di tabel publik.
File upload divalidasi tipe dan ukurannya sebelum disimpan ke storage.
🚀 Kesiapan Multi-Desa

Walaupun implementasi awal hanya untuk satu desa, seluruh struktur sudah siap untuk multi-desa:

Semua tabel konten memiliki kolom desa_id sebagai referensi.
Semua query wajib difilter berdasarkan desa_id.
Semua pengguna adalah super admin dan dapat mengelola seluruh desa.
📄 Lisensi

Dokumen rancangan ini merupakan bagian dari pengembangan internal Sistem Informasi Desa Digital. Silakan sesuaikan struktur tabel, tipe data, dan aturan validasi saat migration Laravel dibuat.