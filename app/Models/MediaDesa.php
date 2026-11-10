<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaDesa extends Model
{
    use HasFactory;

    protected $table = 'media_desa';

    protected $fillable = [
        'judul',
        'file_path',
        'jenis',
        'keterangan',
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
