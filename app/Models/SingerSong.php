<?php

namespace App\Models;

use App\Models\Singer;
use App\Models\Song;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SingerSong extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'singer_songs';

    protected $fillable = [
        'song_id', 'singer_id'
    ];

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }

    public function singer(): BelongsTo
    {
        return $this->belongsTo(Singer::class, 'singer_id', 'id');
    }

}
