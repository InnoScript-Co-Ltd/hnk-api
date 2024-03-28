<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lyric extends Model
{
    use BasicAudit, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'lyrics';

    protected $fillable = [
        'name', 'song_id', 'lyrics',
    ];

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }
}
