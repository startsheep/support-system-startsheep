<?php

namespace App\Http\Traits;

use App\Models\User;
use App\Notifications\SendEmailAssignTo;
use App\Notifications\SendEmailVerification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

trait SendEmail
{
    public static function sendEmail($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = Password::createToken($user);

            $url = url("/auth/new-password?token=$token&email=$email");
            return Notification::route('mail', $email)->notify(new SendEmailVerification($url));
        }
    }

    public static function sendEmailAssignTo($data, $staffId)
    {
        $staff = User::where('id', $staffId)->first();
        $data = $data->get();

        if ($data) {
            return Notification::route('mail', $staff->email)->notify(new SendEmailAssignTo($data));
        }
    }
}
