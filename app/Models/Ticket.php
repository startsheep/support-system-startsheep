<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'company',
        'project',
        'domain',
        'description',
        'created_by',
    ];

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
