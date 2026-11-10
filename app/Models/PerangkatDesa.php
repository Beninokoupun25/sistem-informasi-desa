<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerangkatDesa extends Model
{
    use HasFactory;

    protected $table = 'perangkat_desa';

    protected $fillable = [
        'nama',
        'jabatan',
        'foto_path',
        'kontak',
        'urutan',
        'status',
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
