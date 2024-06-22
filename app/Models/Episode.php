<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Episode extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'episodes';

    protected $fillable = [
        'singer_id',
        'title',
        'url',
        'status',
    ];

    public function singer(): HasOne
    {
        return $this->hasOne(Singer::class, 'id', 'singer_id');
    }
}
