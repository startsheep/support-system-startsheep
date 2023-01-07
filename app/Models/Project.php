<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_name',
        'project_domain',
    ];

    public function userHasProject()
    {
        return $this->hasMany(UserHasProject::class, 'project_id', 'id');
    }
}
