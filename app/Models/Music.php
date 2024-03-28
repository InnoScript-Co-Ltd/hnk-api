<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use BasicAudit, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'musics';

    protected $fillable = [
        'user_id', 'audios',
    ];

    protected $casts = [
        'audios' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
