<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WilayahDesa extends Model
{
    use HasFactory;

    protected $table = 'wilayah_desa';

    protected $fillable = [
        'luas_wilayah',
        'latitude',
        'longitude',
        'batas_utara',
        'batas_selatan',
        'batas_timur',
        'batas_barat',
        'geojson_path',
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
