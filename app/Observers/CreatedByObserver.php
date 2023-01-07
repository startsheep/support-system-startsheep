<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class CreatedByObserver
{
    public function creating($model)
    {
        $model->created_by = Auth::check() ? Auth::user()->id : null;
    }
}
