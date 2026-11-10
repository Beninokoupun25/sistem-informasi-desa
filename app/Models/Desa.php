<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Desa extends Model
{
    use HasFactory;

    protected $table = 'desa';

    protected $fillable = [
        'nama_desa',
        'slug',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function childRouteBindingRelationshipName($childType)
    {
        return Str::camel($childType);
    }

    public function profil(): HasOne
    {
        return $this->hasOne(ProfilDesa::class, 'desa_id');
    }

    public function sejarah(): HasMany
    {
        return $this->hasMany(SejarahDesa::class, 'desa_id');
    }

    public function visiMisi(): HasMany
    {
        return $this->hasMany(VisiMisi::class, 'desa_id');
    }

    public function wilayah(): HasMany
    {
        return $this->hasMany(WilayahDesa::class, 'desa_id');
    }

    public function perangkat(): HasMany
    {
        return $this->hasMany(PerangkatDesa::class, 'desa_id');
    }

    public function statistik(): HasMany
    {
        return $this->hasMany(StatistikDesa::class, 'desa_id');
    }

    public function fasilitas(): HasMany
    {
        return $this->hasMany(FasilitasDesa::class, 'desa_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(MediaDesa::class, 'desa_id');
    }

    public function pengguna(): HasMany
    {
        return $this->hasMany(User::class, 'desa_id');
    }
}
