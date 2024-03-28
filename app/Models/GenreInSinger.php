<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GenreInSinger extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'genre_in_singers';

    protected $fillable = [
        'singers_id', 'genre_id',
    ];

    public function genres(): BelongsTo
    {
        return $this->belongsTo(Genres::class, 'genre_id', 'id');
    }

    public function singer(): BelongsTo
    {
        return $this->belongsTo(Singer::class, 'singers_id', 'id');
    }
}
