<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    const ROLE_ADMIN = 1;

    const ROLE_STAFF = 2;

    const ROLE_CUSTOMER = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        return $this->attributes['password'] = Hash::make($password);
    }

    public function getRoleAdmin()
    {
        return self::ROLE_ADMIN;
    }

    public function getRoleStaff()
    {
        return self::ROLE_STAFF;
    }

    public function getRoleCustomer()
    {
        return self::ROLE_CUSTOMER;
    }

    public function staffHasProject()
    {
        return $this->hasOne(UserHasProject::class, 'user_id', 'id');
    }

    public function customerHasProject()
    {
        return $this->hasOne(UserHasProject::class, 'user_id', 'id');
    }
}
