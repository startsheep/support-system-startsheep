<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $user = User::with('roles')->find($user->id);

        return response()->json([
            'user' => $user,
            'permission' => $this->permissionGenerate($user),
            'role' => $user->roles->pluck('name')
        ]);
    }

    public function permissionGenerate($user)
    {
        $permission = [];
        $perm = $user->getAllPermissions()->pluck('name');
        foreach ($perm as $item) {
            $var = explode('.', $item);
            $permission[$var[0]][] = $var[1];
        }
        return $permission;
    }
}
