<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'images';

    protected $fillable = ['image', 'imageable_type', 'imageable_id'];

    protected $hidden = [
        'imageable_type', 'imageable_id', 'created_at', 'updated_at', 'deleted_at',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
