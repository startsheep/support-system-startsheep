<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\UserRepository;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(LoginRequest $request)
    {
        $user = $this->userRepository->findByCriteria(['email' => $request->email]);

        if (!$user) {
            return response()->json([
                'message' => 'email or password wrong!',
            ], 400);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'email or password wrong!',
            ], 400);
        }

        if ($user->email_verified_at === null) {
            return response()->json([
                'message' => 'please verify your email!',
            ], 400);
        }

        $role = strtolower($user->roles->pluck('name'));

        $token = $user->createToken('api', [$role]);

        Auth::login($user);

        return response()->json([
            'message' => 'Login success!',
            'data' => [
                'user' => $user,
                'token' => $token->plainTextToken,
            ],
        ]);
    }
}
