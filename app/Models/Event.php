<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use BasicAudit, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'name',
        'cover_photo',
        'status',
        'location',
        'address',
        'phone',
        'date',
        'time',
        'promotion',
    ];

    public function coverPhoto()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
