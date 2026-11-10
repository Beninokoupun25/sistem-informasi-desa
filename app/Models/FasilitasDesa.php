<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FasilitasDesa extends Model
{
    use HasFactory;

    protected $table = 'fasilitas_desa';

    protected $fillable = [
        'nama',
        'kategori',
        'alamat',
        'latitude',
        'longitude',
        'deskripsi',
        'foto_path',
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
