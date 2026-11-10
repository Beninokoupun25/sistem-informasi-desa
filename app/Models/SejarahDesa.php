<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SejarahDesa extends Model
{
    use HasFactory;

    protected $table = 'sejarah_desa';

    protected $fillable = [
        'judul',
        'isi',
        'foto_path',
        'urutan',
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
