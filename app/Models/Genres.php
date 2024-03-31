<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genres extends Model
{
    use BasicAudit, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'genres';

    protected $fillable = [
        'name', 'rate', 'color', 'status',
    ];

    public function icon()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function ratePercentage()
    {
        $generes = $this;

        return $generes;
    }
}
