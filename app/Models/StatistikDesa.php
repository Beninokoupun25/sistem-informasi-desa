<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatistikDesa extends Model
{
    use HasFactory;

    protected $table = 'statistik_desa';

    protected $fillable = [
        'tahun',
        'jumlah_penduduk',
        'laki_laki',
        'perempuan',
        'jumlah_kk',
        'jumlah_dusun',
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
