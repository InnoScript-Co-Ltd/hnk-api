<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genres extends Model
{
    use HasFactory, HasUuids, BasicAudit, SoftDeletes;

    protected $table = 'genres';

    protected $fillable = [
        'name', 'rate'
    ];
}
