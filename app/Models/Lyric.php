<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lyric extends Model
{
    use HasFactory, HasUuids, BasicAudit, SoftDeletes;

    protected $table = 'lyrics';

    protected $fillable = [
        'name', 'song_id', 'lyrics'
    ];
}
