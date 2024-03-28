<?php

namespace App\Models;

use App\Traits\BasicAudit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoUpload extends Model
{
    use BasicAudit, HasFactory, HasUuids, SoftDeletes;

    protected $table = 'video_uploads';

    protected $fillable = [
        'user_id',
        'video_path',
    ];

    protected $casts = [
        'video_path' => 'array',
    ];
}
