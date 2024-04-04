<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use BasicAudit, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'outlets';

    protected $fillable = [
        'name', 'phone', 'date', 'address', 'time', 'promotion', 'promo_description', 'latitude', 'longitude', 'status',
        'branch', 'month', 'activation_date', 'description', 'music_band'
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
