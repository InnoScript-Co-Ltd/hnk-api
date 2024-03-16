<?php

namespace App\Models;

use App\Traits\BasicAudit;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Music extends Model
{
    use BasicAudit, HasFactory, HasUuids, SoftDeletes;

    protected $table = "musics";

    protected $fillable = [
        'user_id', 'audios'
    ];

    protected $casts = [
        'audios' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
