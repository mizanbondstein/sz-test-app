<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function findByEmail($email)
    {
        return User::where("email", $email)->first();
    }
    public function logout()
    {
        return  Auth::user()->tokens()->where('id', Auth::user()->currentAccessToken()->id)->delete();
    }
}
