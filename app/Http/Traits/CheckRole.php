<?php

namespace App\Http\Traits;

trait CheckRole
{
    public function isAdmin()
    {
        if ($this->role_id === $this->getRoleAdmin()) {
            return true;
        }

        return false;
    }

    public function isStaff()
    {
        if ($this->role_id === $this->getRoleStaff()) {
            return true;
        }

        return false;
    }

    public function isCustomer()
    {
        if ($this->role_id === $this->getRoleCustomer()) {
            return true;
        }

        return false;
    }
}
