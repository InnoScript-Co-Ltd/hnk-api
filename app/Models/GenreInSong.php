<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GenreInSong extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'genre_in_songs';

    protected $fillable = [
        'song_id', 'genre_id',
    ];

    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genres::class, 'genre_id', 'id');
    }

    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class, 'song_id', 'id');
    }
}
