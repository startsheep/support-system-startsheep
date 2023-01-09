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

    public function countCustomer()
    {
        $user = [];
        foreach ($this->userHasProject as $userHasProject) {
            if ($userHasProject->user->hasRole(User::ROLE_CUSTOMER)) {
                $user[] = $userHasProject->user;
            }
        }

        return count($user);
    }

    public function countTicket()
    {
        return $this->hasMany(Ticket::class, 'project_id', 'id')->count();
    }
}
