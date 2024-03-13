<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use HasFactory, HasUuids, BasicAudit, SoftDeletes;

    protected $table = 'outlets';

    protected $fillable = [
        'name', 'phone', 'date', 'address', 'time', 'promotion', 'promo_description', 'latitude', 'longitude'
    ];
}
