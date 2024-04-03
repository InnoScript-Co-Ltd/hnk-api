<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Singer extends Model
{
    use BasicAudit, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'singers';

    protected $fillable = [
        'name', 'status', 'song_id',
    ];

    protected $casts = [
        'song_id' => 'json',
    ];

    public function profile()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
