# AGENTS.md

Laravel 10 app (PHP ^8.1) — Sistem Informasi Desa Digital (Indonesian village information system). JSON API in routes/api.php (public GET endpoints + Sanctum-authenticated mutations gated by `manage-desa`/`create-desa` in AuthServiceProvider) plus public Blade pages (routes/web.php → PageController → resources/views/pages/, Indonesian UI, plain CSS via Vite + Leaflet from CDN). Breeze auth IS installed (routes/auth.php: login/logout/password reset) and an admin UI exists under the `auth` + `/admin` prefix with controllers in app/Http/Controllers/Admin/. Read the `sistem` section of README.md (ERD spec) before changing migrations or models.

## Commands

- Tests: `php artisan test` (PHPUnit 10, not Pest)
- Single test: `php artisan test --filter=ExampleTest` (also `--filter=HalamanPublikTest`, `--filter=ModulProfilDesaTest`, `--filter=ProfileTest`; `tests/Feature/Auth/` holds auth tests)
- PHP formatting: `.\vendor\bin\pint` (add `--test` to check only; default Laravel preset, no `pint.json`)
- Frontend: `npm install` first if needed (node_modules exists and public/build is committed... actually built), then `npm run dev` or `npm run build`
- Seed sample village content incl. placeholder SVG/GeoJSON files: `php artisan db:seed` (DesaSeeder is idempotent — updateOrCreate + child delete/recreate)

## Environment

- Laragon on Windows; MySQL database `db_sistem_informasi_desa`, user `root` (`.env` exists locally); both dev and `db_sistem_informasi_desa_testing` databases exist
- Dev DB is migrated and seeded (`Desa Sukamaju`); `php artisan storage:link` has been run (public/storage → storage/app/public)
- Not a git repo — no history, branches, or remotes
- `phpunit.xml` has the sqlite `:memory:` env lines commented out — DB-touching feature tests run against the MySQL database from `.env` unless you override `DB_CONNECTION`/`DB_DATABASE`. Run tests with `$env:DB_DATABASE='db_sistem_informasi_desa_testing'; php artisan test` ( pdo_sqlite is NOT in this PHP build, so sqlite override is not an option; plain `php artisan test` would RefreshDatabase-wipe the dev DB)

## Domain rules from the README spec

- `desa` is the parent entity; every content table (`profil_desa`, `sejarah_desa`, `visi_misi`, `wilayah_desa`, `perangkat_desa`, `statistik_desa`, `fasilitas_desa`, `media_desa`) carries a `desa_id` FK. Always scope content queries by `desa_id`, even though only one desa exists initially
- Auth: use the Laravel Breeze `users` table, extended with `desa_id` (nullable), `role` (single role `super_admin`, default `super_admin`), `status` (default `aktif`) — do not create a separate `pengguna` table. Every user is a super admin with lintas desa access; authorization checks only `status === 'aktif'` (gates `create-desa`/`manage-desa`); `desa_id` on users is no longer used for authorization scope
- Files: store uploads with `->store($dir, 'public')` and save the path in `*_path` columns, never as DB blobs; GeoJSON boundary files go to storage
- Unique constraints: `profil_desa.desa_id` (1:1 with desa); `(desa_id, tahun)` on `statistik_desa`
- Relations per spec: `Desa->profil()` is hasOne, the rest are hasMany, all with explicit `desa_id` foreign key
- Table/column names are Indonesian; passwords are always hashed; NIK and personal documents must not be stored
- Out of scope for now: layanan surat online, pengaduan, bantuan sosial, transaksi pelayanan

## Routing gotchas (verified the hard way)

- All Eloquent models set `protected $table` explicitly — Indonesian names don't pluralize (`ProfilDesa` would default to `profil_desas`), and `constrained()` must be `constrained('desa')` since `Str::plural('desa')` guesses `desas`
- `Route::scopeBindings()` as a standalone call in a provider does nothing (gets swallowed by RouteRegistrar as an unapplied attribute); scoping is chained on the api route group in RouteServiceProvider. Scoped nested bindings match the route param name to a relation on Desa
- Indonesian relation names are singular, but Laravel's scoped binding pluralizes the param name (`sejarah` → `sejarahs`) — `Desa::childRouteBindingRelationshipName()` is overridden to use `Str::camel` only. Keep route params named exactly like the relations (`{sejarah}`, `{visiMisi}`, ...)
- `Desa::getRouteKeyName()` is `slug` — public URLs bind desa by slug, not id
- Public pages resolve the displayed desa from `session('desa_slug')` (fallback: first active desa, then re-stored in session). Switching goes through `POST /pilih-desa` (`PageController::pilihDesa`) — CSRF-protected, validates the slug is an active desa, only redirects back to same-origin `kembali` URLs. The desa switcher in `layouts/app` is rendered from a view composer on `AppServiceProvider` (`$semuaDesa`), only shown when >1 active desa exists
- There are two `POST /pilih-desa` routes: the public one in `PageController` and an admin one in `Admin\DashboardController` (`/admin/pilih-desa`) — don't confuse them.
