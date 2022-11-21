<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fileable_id',
        'fileable_type',
        'file_path',
        'file_name',
    ];

    public function getFilePathAttribute($filePath)
    {
        return $this->attributes['file_path'] = url('storage/' . $filePath);
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
